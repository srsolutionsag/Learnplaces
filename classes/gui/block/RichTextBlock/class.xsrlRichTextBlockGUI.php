<?php
declare(strict_types=1);

use ILIAS\HTTP\GlobalHttpState;
use SRAG\Learnplaces\gui\block\RichTextBlock\RichTextBlockEditFormView;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\RichTextBlockService;
use SRAG\Learnplaces\service\publicapi\model\RichTextBlockModel;

/**
 * Class xsrlRichTextBlock
 *
 * @package SRAG\Learnplaces\gui\block\RichTextBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlRichTextBlockGUI {

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
	 * @var RichTextBlockService $richTextBlockService
	 */
	private $richTextBlockService;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;
	/**
	 * @var ConfigurationService $configService
	 */
	private $configService;


	/**
	 * xsrlRichTextBlockGUI constructor.
	 *
	 * @param ilTabsGUI            $tabs
	 * @param ilTemplate           $template
	 * @param ilCtrl               $controlFlow
	 * @param ilAccessHandler      $access
	 * @param GlobalHttpState      $http
	 * @param ilLearnplacesPlugin  $plugin
	 * @param RichTextBlockService $richTextBlockService
	 * @param LearnplaceService    $learnplaceService
	 * @param ConfigurationService $configService
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilAccessHandler $access, GlobalHttpState $http, ilLearnplacesPlugin $plugin, RichTextBlockService $richTextBlockService, LearnplaceService $learnplaceService, ConfigurationService $configService) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->access = $access;
		$this->http = $http;
		$this->plugin = $plugin;
		$this->richTextBlockService = $richTextBlockService;
		$this->learnplaceService = $learnplaceService;
		$this->configService = $configService;
	}


	public function executeCommand() {

		$this->template->getStandardTemplate();
		$cmd = $this->controlFlow->getCmd(CommonControllerAction::CMD_INDEX);
		$this->tabs->activateTab(self::TAB_ID);

		switch ($cmd) {
			case CommonControllerAction::CMD_INDEX:
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
		$config = $this->configService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		$block = new RichTextBlockModel();

		$block->setVisibility($config->getDefaultVisibility());
		$form = new RichTextBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function create() {

		$form = new RichTextBlockEditFormView(new RichTextBlockModel());
		try {
			//store block
			/**
			 * @var RichTextBlockModel $block
			 */
			$block = $form->getBlockModel();
			$block = $this->richTextBlockService->store($block);

			//fetch learnplace
			$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));

			//store relation learnplace <-> block
			$blocks = $learnplace->getBlocks();
			$blocks[] = $block;
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
		catch (FileUploadException $ex) {
			$form->setValuesByPost();
			$this->template->setContent($form->getHTML());
		}
	}

	private function edit() {
		$block = $this->richTextBlockService->find($this->getBlockId());
		$form = new RichTextBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function update() {

		$form = new RichTextBlockEditFormView(new RichTextBlockModel());
		try {
			//store block
			/**
			 * @var RichTextBlockModel $block
			 */
			$block = $form->getBlockModel();
			$this->richTextBlockService->store($block);

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
		$this->richTextBlockService->delete($blockId);
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

	private function cancel() {
		$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
	}

	private function getBlockId(): int {
		return intval($this->http->request()->getQueryParams()[self::BLOCK_ID_QUERY_KEY]);
	}

}