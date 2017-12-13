<?php
declare(strict_types=1);

use ILIAS\HTTP\GlobalHttpState;
use SRAG\Learnplaces\gui\block\AccordionBlock\AccordionBlockEditFormView;
use SRAG\Learnplaces\gui\block\util\InsertPositionAware;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;

/**
 * Class xsrlAccordionBlock
 *
 * @package SRAG\Learnplaces\gui\block\AccordionBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlAccordionBlockGUI {

	use InsertPositionAware;

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
	 * @var GlobalHttpState $http
	 */
	private $http;
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
	 * xsrlAccordionBlockGUI constructor.
	 *
	 * @param ilTabsGUI             $tabs
	 * @param ilTemplate            $template
	 * @param ilCtrl                $controlFlow
	 * @param ilAccessHandler       $access
	 * @param GlobalHttpState       $http
	 * @param ilLearnplacesPlugin   $plugin
	 * @param AccordionBlockService $accordionService
	 * @param LearnplaceService     $learnplaceService
	 * @param ConfigurationService  $configService
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilAccessHandler $access, GlobalHttpState $http, ilLearnplacesPlugin $plugin, AccordionBlockService $accordionService, LearnplaceService $learnplaceService, ConfigurationService $configService) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->access = $access;
		$this->http = $http;
		$this->plugin = $plugin;
		$this->accordionService = $accordionService;
		$this->learnplaceService = $learnplaceService;
		$this->configService = $configService;
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
				if ($this->checkRequestReferenceId()) {
					$this->{$cmd}();
				}
				break;
		}
		$this->template->show();

		return true;
	}

	private function checkRequestReferenceId() {
		/**
		 * @var $ilAccess \ilAccessHandler
		 */
		$ref_id = $this->getCurrentRefId();
		if ($ref_id) {
			return $this->access->checkAccess("read", "", $ref_id);
		}

		return true;
	}

	private function getCurrentRefId(): int {
		return intval($this->http->request()->getQueryParams()["ref_id"]);
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
			//store block
			/**
			 * @var AccordionBlockModel $block
			 */
			$block = $form->getBlockModel();
			$block = $this->accordionService->store($block);

			//fetch learnplace
			$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));

			//store relation learnplace <-> block
			$blocks = $learnplace->getBlocks();
			array_splice($blocks, $this->getInsertPosition($this->http->request()), 0, [$block]);
			$learnplace->setBlocks($blocks);
			$this->learnplaceService->store($learnplace);

			ilUtil::sendSuccess($this->plugin->txt('message_changes_save_success'), true);
			$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
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
			$accordion = $this->accordionService->find($block->getId());
			$block->setBlocks($accordion->getBlocks());
			$this->accordionService->store($block);

			ilUtil::sendSuccess($this->plugin->txt('message_changes_save_success'), true);
			$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
		}
		catch (ValidationException $ex) {
			$form->setValuesByPost();
			$this->template->setContent($form->getHTML());
		}
	}

	private function delete() {
		$blockId = intval($this->http->request()->getQueryParams()[self::BLOCK_ID_QUERY_KEY]);
		$this->accordionService->delete($blockId);
		ilUtil::sendSuccess($this->plugin->txt('message_delete_success'), true);
		$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
	}

	private function confirm() {
		$confirm = new ilConfirmationGUI();
		$confirm->setHeaderText($this->plugin->txt('confirm_delete_header'));
		$confirm->setFormAction(
			$this->controlFlow->getFormAction($this) .
			'&' .
			self::BLOCK_ID_QUERY_KEY .
			'=' .
			$this->http->request()->getQueryParams()[self::BLOCK_ID_QUERY_KEY]
		);
		$confirm->setConfirm($this->plugin->txt('common_delete'), CommonControllerAction::CMD_DELETE);
		$confirm->setCancel($this->plugin->txt('common_cancel'), CommonControllerAction::CMD_CANCEL);
		$this->template->setContent($confirm->getHTML());
	}

	private function getBlockId(): int {
		return intval($this->http->request()->getQueryParams()[self::BLOCK_ID_QUERY_KEY]);
	}
}