<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\gui\block\util\AccordionAware;
use SRAG\Learnplaces\gui\block\util\BlockIdReferenceValidationAware;
use SRAG\Learnplaces\gui\block\util\InsertPositionAware;
use SRAG\Learnplaces\gui\block\util\ReferenceIdAware;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\ILIASLinkBlockService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\ILIASLinkBlockModel;
use SRAG\Learnplaces\service\security\BlockAccessGuard;

/**
 * Class xsrlIliasLinkBlock
 *
 * @package SRAG\Learnplaces\gui\block\IliasLinkBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @ilCtrl_Calls           xsrlIliasLinkBlockGUI: xsrlIliasLinkBlockEditFormViewGUI
 * @ilCtrl_isCalledBy      xsrlIliasLinkBlockGUI: ilInternalLinkGUI
 */
final class xsrlIliasLinkBlockGUI {

	use InsertPositionAware;
	use AccordionAware;
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
	 * @var ilAccessHandler $access
	 */
	private $access;
	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var ILIASLinkBlockService $iliasLinkService
	 */
	private $iliasLinkService;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;
	/**
	 * @var ConfigurationService $configService
	 */
	private $configService;
	/**
	 * @var AccordionBlockService $accprdionService
	 */
	private $accprdionService;
	/**
	 * @var ServerRequestInterface $request
	 */
	private $request;


	/**
	 * xsrlIliasLinkBlockGUI constructor.
	 *
	 * @param ilTabsGUI              $tabs
	 * @param ilTemplate             $template
	 * @param ilCtrl                 $controlFlow
	 * @param ilAccessHandler        $access
	 * @param ilLearnplacesPlugin    $plugin
	 * @param ILIASLinkBlockService  $iliasLinkService
	 * @param LearnplaceService      $learnplaceService
	 * @param ConfigurationService   $configService
	 * @param AccordionBlockService  $accprdionService
	 * @param ServerRequestInterface $request
	 * @param BlockAccessGuard       $blockAccessGuard
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilAccessHandler $access, ilLearnplacesPlugin $plugin, ILIASLinkBlockService $iliasLinkService, LearnplaceService $learnplaceService, ConfigurationService $configService, AccordionBlockService $accprdionService, ServerRequestInterface $request, BlockAccessGuard $blockAccessGuard) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->access = $access;
		$this->plugin = $plugin;
		$this->iliasLinkService = $iliasLinkService;
		$this->learnplaceService = $learnplaceService;
		$this->configService = $configService;
		$this->accprdionService = $accprdionService;
		$this->request = $request;
		$this->blockAccessGuard = $blockAccessGuard;
	}


	public function executeCommand() {
$next_class = $this->controlFlow->getNextClass();
		$this->template->getStandardTemplate();
		$cmd = $this->controlFlow->getCmd(CommonControllerAction::CMD_INDEX);
		$this->tabs->activateTab(self::TAB_ID);

		if($next_class === strtolower(xsrlIliasLinkBlockEditFormViewGUI::class))
			$this->controlFlow->forwardCommand(new xsrlIliasLinkBlockEditFormViewGUI(new ILIASLinkBlockModel()));

		switch ($cmd) {
			case CommonControllerAction::CMD_ADD:
			case CommonControllerAction::CMD_CANCEL:
			case CommonControllerAction::CMD_CONFIRM:
			case CommonControllerAction::CMD_CREATE:
			case CommonControllerAction::CMD_DELETE:
			case CommonControllerAction::CMD_EDIT:
			case CommonControllerAction::CMD_UPDATE:
				if ($this->checkRequestReferenceId('write')) {
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
		$this->controlFlow->saveParameter($this, PlusView::ACCORDION_QUERY_PARAM);

		$config = $this->configService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		$block = new ILIASLinkBlockModel();

		$block->setVisibility($config->getDefaultVisibility());
		$form = new xsrlIliasLinkBlockEditFormViewGUI($block);

		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function create() {
		$form = new xsrlIliasLinkBlockEditFormViewGUI(new ILIASLinkBlockModel());
		try {
			$queries = $this->request->getQueryParams();

			//store block
			/**
			 * @var ILIASLinkBlockModel $block
			 */
			$block = $form->getBlockModel();
			$block->setId(0); //mitigate block id injection
			$accordionId = $this->getCurrentAccordionId($queries);
			if($accordionId > 0)
				$this->redirectInvalidRequests($accordionId);

			$block = $this->iliasLinkService->store($block);


			if($accordionId > 0) {
				$accordion = $this->accprdionService->find($accordionId);
				$blocks = $accordion->getBlocks();
				array_splice($blocks, $this->getInsertPosition($queries), 0, [$block]);
				$accordion->setBlocks($blocks);
				$this->accprdionService->store($accordion);
			}
			else {
				//fetch learnplace
				$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));

				//store relation learnplace <-> block
				$blocks = $learnplace->getBlocks();
				array_splice($blocks, $this->getInsertPosition($queries), 0, [$block]);
				$learnplace->setBlocks($blocks);
				$this->learnplaceService->store($learnplace);
			}

			ilUtil::sendSuccess($this->plugin->txt('message_changes_save_success'), true);
			$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
		}
		catch (ValidationException $ex) {
			$form->setValuesByPost();
			$this->template->setContent($form->getHTML());
		}
	}

	private function edit() {
		$blockId = $this->getBlockId();
		$block = $this->iliasLinkService->find($blockId);
		$form = new xsrlIliasLinkBlockEditFormViewGUI($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function update() {
		$form = new xsrlIliasLinkBlockEditFormViewGUI(new ILIASLinkBlockModel());
		try {
			//store block
			/**
			 * @var ILIASLinkBlockModel $block
			 */
			$block = $form->getBlockModel();
			$this->redirectInvalidRequests($block->getId());

			$this->iliasLinkService->store($block);

			ilUtil::sendSuccess($this->plugin->txt('message_changes_save_success'), true);
			$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
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

		$this->iliasLinkService->delete($blockId);
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