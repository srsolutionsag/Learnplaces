<?php
declare(strict_types=1);

use ILIAS\HTTP\GlobalHttpState;
use SRAG\Learnplaces\gui\block\PictureUploadBlock\PictureUploadBlockEditFormView;
use SRAG\Learnplaces\gui\block\util\AccordionAware;
use SRAG\Learnplaces\gui\block\util\InsertPositionAware;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\PictureUploadBlockService;
use SRAG\Learnplaces\service\publicapi\model\PictureUploadBlockModel;

/**
 * Class xsrlPictureUploadBlockGUI
 *
 * @package SRAG\Learnplaces\gui
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlPictureUploadBlockGUI {

	use InsertPositionAware;
	use  AccordionAware;

	const TAB_ID = 'edit-block';
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
	 * @var PictureUploadBlockService $pictureUploadService
	 */
	private $pictureUploadService;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;
	/**
	 * @var ConfigurationService $configService
	 */
	private $configService;
	/**
	 * @var AccordionBlockService $accordionService
	 */
	private $accordionService;


	/**
	 * xsrlPictureUploadBlockGUI constructor.
	 *
	 * @param ilTabsGUI                 $tabs
	 * @param ilTemplate                $template
	 * @param ilCtrl                    $controlFlow
	 * @param ilAccessHandler           $access
	 * @param GlobalHttpState           $http
	 * @param ilLearnplacesPlugin       $plugin
	 * @param PictureUploadBlockService $pictureUploadService
	 * @param LearnplaceService         $learnplaceService
	 * @param ConfigurationService      $configService
	 * @param AccordionBlockService     $accordionService
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilAccessHandler $access, GlobalHttpState $http, ilLearnplacesPlugin $plugin, PictureUploadBlockService $pictureUploadService, LearnplaceService $learnplaceService, ConfigurationService $configService, AccordionBlockService $accordionService) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->access = $access;
		$this->http = $http;
		$this->plugin = $plugin;
		$this->pictureUploadService = $pictureUploadService;
		$this->learnplaceService = $learnplaceService;
		$this->configService = $configService;
		$this->accordionService = $accordionService;
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
		$this->controlFlow->saveParameter($this, PlusView::POSITION_QUERY_PARAM);
		$this->controlFlow->saveParameter($this, PlusView::ACCORDION_QUERY_PARAM);

		$config = $this->configService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		$block = new PictureUploadBlockModel();

		$block->setVisibility($config->getDefaultVisibility());
		$form = new PictureUploadBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function create() {
		$form = new PictureUploadBlockEditFormView(new PictureUploadBlockModel());
		try {
			//store block
			$block = $form->getBlockModel();
			$block = $this->pictureUploadService->store($block);

			$accordionId = $this->getCurrentAccordionId($this->http->request());
			if($accordionId > 0) {
				$accordion = $this->accordionService->find($accordionId);
				$blocks = $accordion->getBlocks();
				array_splice($blocks, $this->getInsertPosition($this->http->request()), 0, [$block]);
				$accordion->setBlocks($blocks);
				$this->accordionService->store($accordion);
			}
			else {
				//fetch learnplace
				$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));

				//store relation learnplace <-> block
				$blocks = $learnplace->getBlocks();
				array_splice($blocks, $this->getInsertPosition($this->http->request()), 0, [$block]);
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
		catch (InvalidArgumentException $ex) {
			$form->setValuesByPost();
			$this->template->setContent($form->getHTML());
		}
	}

	private function delete() {
		$blockId = intval($this->http->request()->getQueryParams()[self::BLOCK_ID_QUERY_KEY]);
		$this->pictureUploadService->delete($blockId);
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
}