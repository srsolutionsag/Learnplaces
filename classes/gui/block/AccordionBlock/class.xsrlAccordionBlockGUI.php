<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\gui\block\AccordionBlock\AccordionBlockEditFormView;
use SRAG\Learnplaces\gui\block\util\BlockIdReferenceValidationAware;
use SRAG\Learnplaces\gui\block\util\InsertPositionAware;
use SRAG\Learnplaces\gui\block\util\ReferenceIdAware;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\security\AccessGuard;

/**
 * Class xsrlAccordionBlock
 *
 * @package SRAG\Learnplaces\gui\block\AccordionBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlAccordionBlockGUI {

	use InsertPositionAware;
	use BlockIdReferenceValidationAware;
	use ReferenceIdAware;

	const TAB_ID = 'Content';
	const BLOCK_ID_QUERY_KEY = 'block';

	/**
	 * @var ilTabsGUI $tabs
	 */
	private $tabs;
	/**
	 * @var ilTemplate $template
	 */
	private $template;
	/**
	 * @var ilCtrl $controlFlow
	 */
	private $controlFlow;
	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var AccordionBlockService $accordionService
	 */
	private $accordionService;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;
	/**
	 * @var ConfigurationService $configService
	 */
	private $configService;
	/**
	 * @var ServerRequestInterface $request
	 */
	private $request;
	/**
	 * @var AccessGuard $blockAccessGuard
	 */
	private $blockAccessGuard;


	/**
	 * xsrlAccordionBlockGUI constructor.
	 *
	 * @param ilTabsGUI              $tabs
	 * @param ilTemplate             $template
	 * @param ilCtrl                 $controlFlow
	 * @param ilLearnplacesPlugin    $plugin
	 * @param AccordionBlockService  $accordionService
	 * @param LearnplaceService      $learnplaceService
	 * @param ConfigurationService   $configService
	 * @param ServerRequestInterface $request
	 * @param AccessGuard            $blockAccessGuard
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilLearnplacesPlugin $plugin, AccordionBlockService $accordionService, LearnplaceService $learnplaceService, ConfigurationService $configService, ServerRequestInterface $request, AccessGuard $blockAccessGuard) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->plugin = $plugin;
		$this->accordionService = $accordionService;
		$this->learnplaceService = $learnplaceService;
		$this->configService = $configService;
		$this->request = $request;
		$this->blockAccessGuard = $blockAccessGuard;
	}


	public function executeCommand() {

		$this->template->getStandardTemplate();
		$cmd = $this->controlFlow->getCmd(CommonControllerAction::CMD_INDEX);
		$this->tabs->activateTab(self::TAB_ID);

		switch ($cmd) {
			case CommonControllerAction::CMD_ADD:
			case CommonControllerAction::CMD_CANCEL:
			case CommonControllerAction::CMD_CONFIRM:
			case CommonControllerAction::CMD_CREATE:
			case CommonControllerAction::CMD_DELETE:
			case CommonControllerAction::CMD_EDIT:
			case CommonControllerAction::CMD_UPDATE:
				if ($this->blockAccessGuard->hasWritePermission()) {
					$this->{$cmd}();
					$this->template->show();
					return true;
				}
				break;
		}
		ilUtil::sendFailure($this->plugin->txt('common_access_denied'), true);
		$this->controlFlow->redirectByClass(ilRepositoryGUI::class);

		return false;
	}

	private function add() {
		$this->controlFlow->saveParameter($this, PlusView::POSITION_QUERY_PARAM);

		$config = $this->configService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		$block = new AccordionBlockModel();

		$block->setVisibility($config->getDefaultVisibility());
		$form = new AccordionBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function create() {
		$form = new AccordionBlockEditFormView(new AccordionBlockModel());
		try {
			$queries = $this->request->getQueryParams();

			//store block
			/**
			 * @var AccordionBlockModel $block
			 */
			$block = $form->getBlockModel();
			$block->setId(0); //mitigate injection of block id
			$block = $this->accordionService->store($block);

			//fetch learnplace
			$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));

			//store relation learnplace <-> block
			$blocks = $learnplace->getBlocks();
			array_splice($blocks, $this->getInsertPosition($queries), 0, [$block]);
			$learnplace->setBlocks($blocks);
			$this->learnplaceService->store($learnplace);

			ilUtil::sendSuccess($this->plugin->txt('message_changes_save_success'), true);
			$anchor = xsrlContentGUI::ANCHOR_TEMPLATE . $block->getSequence();
			$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX, $anchor);
		}
		catch (ValidationException $ex) {
			$form->setValuesByPost();
			$this->template->setContent($form->getHTML());
		}
		catch (LogicException $ex) {
			$form->setValuesByPost();
			$this->template->setContent($form->getHTML());
		}
	}

	private function edit() {
		$block = $this->accordionService->find($this->getBlockId());
		$form = new AccordionBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function update() {
		$form = new AccordionBlockEditFormView(new AccordionBlockModel());
		try {
			//store block
			/**
			 * @var AccordionBlockModel $block
			 */
			$block = $form->getBlockModel();
			$this->redirectInvalidRequests($block->getId());
			$accordion = $this->accordionService->find($block->getId());
			$accordion->setTitle($block->getTitle());
			$accordion->setExpand($block->isExpand());
			$accordion->setVisibility($block->getVisibility());
			$this->accordionService->store($accordion);

			ilUtil::sendSuccess($this->plugin->txt('message_changes_save_success'), true);
			$anchor = xsrlContentGUI::ANCHOR_TEMPLATE . $block->getSequence();
			$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX, $anchor);
		}
		catch (ValidationException $ex) {
			$form->setValuesByPost();
			$this->template->setContent($form->getHTML());
		}
	}

	private function delete() {
		$queries = $this->request->getQueryParams();
		$blockId = intval($queries[self::BLOCK_ID_QUERY_KEY]);
		$this->redirectInvalidRequests($blockId);
		$this->accordionService->delete($blockId);
		$this->regenerateSequence();
		ilUtil::sendSuccess($this->plugin->txt('message_delete_success'), true);
		$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
	}

	private function confirm() {
		$queries = $this->request->getQueryParams();

		$confirm = new ilConfirmationGUI();
		$confirm->setHeaderText($this->plugin->txt('confirm_delete_header'));
		$confirm->setFormAction(
			$this->controlFlow->getFormAction($this) .
			'&' .
			self::BLOCK_ID_QUERY_KEY .
			'=' .
			$queries[self::BLOCK_ID_QUERY_KEY]
		);
		$confirm->setConfirm($this->plugin->txt('common_delete'), CommonControllerAction::CMD_DELETE);
		$confirm->setCancel($this->plugin->txt('common_cancel'), CommonControllerAction::CMD_CANCEL);
		$this->template->setContent($confirm->getHTML());
	}

	private function cancel() {
		$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
	}

	private function getBlockId(): int {
		$queries = $this->request->getQueryParams();
		return intval($queries[self::BLOCK_ID_QUERY_KEY]);
	}

	private function regenerateSequence() {
		$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		$this->learnplaceService->store($learnplace);
	}
}