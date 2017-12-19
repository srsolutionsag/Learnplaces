<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\gui\block\PictureBlock\PictureBlockEditFormView;
use SRAG\Learnplaces\gui\block\util\AccordionAware;
use SRAG\Learnplaces\gui\block\util\BlockIdReferenceValidationAware;
use SRAG\Learnplaces\gui\block\util\InsertPositionAware;
use SRAG\Learnplaces\gui\block\util\ReferenceIdAware;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\media\PictureService;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\PictureBlockService;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;
use SRAG\Learnplaces\service\security\BlockAccessGuard;

/**
 * Class xsrlPictureBlockGUI
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlPictureBlockGUI {

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
	 * @var PictureService $pictureService
	 */
	private $pictureService;
	/**
	 * @var PictureBlockService $pictureBlockService
	 */
	private $pictureBlockService;
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
	 * @var ServerRequestInterface $request
	 */
	private $request;


	/**
	 * xsrlPictureBlockGUI constructor.
	 *
	 * @param ilTabsGUI              $tabs
	 * @param ilTemplate             $template
	 * @param ilCtrl                 $controlFlow
	 * @param ilAccessHandler        $access
	 * @param ilLearnplacesPlugin    $plugin
	 * @param PictureService         $pictureService
	 * @param PictureBlockService    $pictureBlockService
	 * @param LearnplaceService      $learnplaceService
	 * @param ConfigurationService   $configService
	 * @param AccordionBlockService  $accordionService
	 * @param ServerRequestInterface $request
	 * @param BlockAccessGuard       $blockAccessGuard
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilAccessHandler $access, ilLearnplacesPlugin $plugin, PictureService $pictureService, PictureBlockService $pictureBlockService, LearnplaceService $learnplaceService, ConfigurationService $configService, AccordionBlockService $accordionService, ServerRequestInterface $request, BlockAccessGuard $blockAccessGuard) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->access = $access;
		$this->plugin = $plugin;
		$this->pictureService = $pictureService;
		$this->pictureBlockService = $pictureBlockService;
		$this->learnplaceService = $learnplaceService;
		$this->configService = $configService;
		$this->accordionService = $accordionService;
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
		$block = new PictureBlockModel();

		$block->setVisibility($config->getDefaultVisibility());
		$form = new PictureBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function create() {
		$form = new PictureBlockEditFormView(new PictureBlockModel());
		try {
			$queries = $this->request->getQueryParams();

			//store block
			/**
			 * @var PictureBlockModel $block
			 */
			$block = $form->getBlockModel();
			$block->setId(0); //mitigate block id injection
			$accordionId = $this->getCurrentAccordionId($queries);
			if($accordionId > 0)
				$this->redirectInvalidRequests($accordionId);

			$picture = $this->pictureService->storeUpload(ilObject::_lookupObjectId($this->getCurrentRefId()));
			$block->setPicture($picture);
			$block = $this->pictureBlockService->store($block);

			if($accordionId > 0) {
				$accordion = $this->accordionService->find($accordionId);
				$blocks = $accordion->getBlocks();
				array_splice($blocks, $this->getInsertPosition($queries), 0, [$block]);
				$accordion->setBlocks($blocks);
				$this->accordionService->store($accordion);
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
		catch (LogicException $ex) {
			$form->setValuesByPost();
			$this->template->setContent($form->getHTML());
		}
		catch (FileUploadException $ex) {
			$form->setValuesByPost();
			ilUtil::sendFailure($this->plugin->txt('video_block_upload_error'));
			$this->template->setContent($form->getHTML());
		}
	}

	private function edit() {
		$blockId = $this->getBlockId();
		$block = $this->pictureBlockService->find($blockId);
		$form = new PictureBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function update() {
		$tempBlock = new PictureBlockModel();
		$tempBlock->setId(PHP_INT_MAX);
		$form = new PictureBlockEditFormView($tempBlock);

		try {
			/**
			 * @var PictureBlockModel $block
			 */
			$block = $form->getBlockModel();
			$this->redirectInvalidRequests($block->getId());

			$oldPictureBlock = $this->pictureBlockService->find($block->getId());
			$oldPicture = $oldPictureBlock->getPicture();
			$block->setPicture($oldPicture);

			$uploadedFiles = $this->request->getUploadedFiles();
			if(count($uploadedFiles) === 1 && array_pop($uploadedFiles)->getError() === UPLOAD_ERR_OK) {
				//store new picture
				$picture = $this->pictureService->storeUpload(ilObject::_lookupObjectId($this->getCurrentRefId()));
				$block->setPicture($picture);

				//delete old picture
				$this->pictureService->delete($oldPicture->getId());
			}

			$this->pictureBlockService->store($block);

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
			ilUtil::sendFailure($this->plugin->txt('picture_block_upload_error'));
			$this->template->setContent($form->getHTML());
		}
	}

	private function delete() {
		$blockId = $this->getBlockId();
		$this->redirectInvalidRequests($blockId);
		$this->pictureBlockService->delete($blockId);
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
}