<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\gui\block\util\AccordionAware;
use SRAG\Learnplaces\gui\block\util\BlockIdReferenceValidationAware;
use SRAG\Learnplaces\gui\block\util\InsertPositionAware;
use SRAG\Learnplaces\gui\block\util\ReferenceIdAware;
use SRAG\Learnplaces\gui\block\VideoBlock\VideoBlockEditFormView;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\media\VideoService;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\VideoBlockService;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;
use SRAG\Learnplaces\service\publicapi\model\VideoModel;
use SRAG\Learnplaces\service\security\BlockAccessGuard;

/**
 * Class xsrlVideoBlockGUI
 *
 * @package SRAG\Learnplaces\gui\block\VideoBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlVideoBlockGUI {

	use InsertPositionAware;
	use AccordionAware;
	use BlockIdReferenceValidationAware;
	use ReferenceIdAware;

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
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var VideoBlockService $videoBlockService
	 */
	private $videoBlockService;
	/**
	 * @var VideoService $videoService
	 */
	private $videoService;
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
	 * xsrlVideoBlockGUI constructor.
	 *
	 * @param ilTabsGUI              $tabs
	 * @param ilTemplate             $template
	 * @param ilCtrl                 $controlFlow
	 * @param ilAccessHandler        $access
	 * @param ilLearnplacesPlugin    $plugin
	 * @param VideoBlockService      $videoBlockService
	 * @param VideoService           $videoService
	 * @param LearnplaceService      $learnplaceService
	 * @param ConfigurationService   $configService
	 * @param AccordionBlockService  $accordionService
	 * @param ServerRequestInterface $request
	 * @param BlockAccessGuard       $blockAccessGuard
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilAccessHandler $access, ilLearnplacesPlugin $plugin, VideoBlockService $videoBlockService, VideoService $videoService, LearnplaceService $learnplaceService, ConfigurationService $configService, AccordionBlockService $accordionService, ServerRequestInterface $request, BlockAccessGuard $blockAccessGuard) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->access = $access;
		$this->plugin = $plugin;
		$this->videoBlockService = $videoBlockService;
		$this->videoService = $videoService;
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
		$block = new VideoBlockModel();

		$block->setVisibility($config->getDefaultVisibility());
		$form = new VideoBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function create() {
		$form = new VideoBlockEditFormView(new VideoBlockModel());
		try {
			$queries = $this->request->getQueryParams();

			//store block
			/**
			 * @var VideoBlockModel $block
			 */
			$block = $form->getBlockModel();
			$block->setId(0); //mitigate block id injection
			$accordionId = $this->getCurrentAccordionId($queries);
			if($accordionId > 0)
				$this->redirectInvalidRequests($block->getId());

			$video = $this->videoService->storeUpload(ilObject::_lookupObjectId($this->getCurrentRefId()));
			$block
				->setPath($video->getCoverPath())
				->setPath($video->getVideoPath());

			$videoBlock = $this->videoBlockService->store($block);

			if($accordionId > 0) {
				$accordion = $this->accordionService->find($accordionId);
				$blocks = $accordion->getBlocks();
				array_splice($blocks, $this->getInsertPosition($queries), 0, [$videoBlock]);
				$accordion->setBlocks($blocks);
				$this->accordionService->store($accordion);
			}
			else {
				//fetch learnplace
				$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));

				//store relation learnplace <-> block
				$blocks = $learnplace->getBlocks();
				array_splice($blocks, $this->getInsertPosition($queries), 0, [$videoBlock]);
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
		$block = $this->videoBlockService->find($blockId);
		$form = new VideoBlockEditFormView($block);
		$form->fillForm();
		$this->template->setContent($form->getHTML());
	}

	private function update() {
		$tempBlock = new VideoBlockModel();
		$tempBlock->setId(PHP_INT_MAX);
		$form = new VideoBlockEditFormView($tempBlock);

		try {
			/**
			 * @var VideoBlockModel $block
			 */
			$block = $form->getBlockModel();
			$this->redirectInvalidRequests($block->getId());
			$oldVideoBlock = $this->videoBlockService->find($block->getId());
			$block
				->setPath($oldVideoBlock->getPath())
				->setCoverPath($oldVideoBlock->getCoverPath());

			$uploadedFiles = $this->request->getUploadedFiles();
			if(count($uploadedFiles) === 1 && array_pop($uploadedFiles)->getError() === UPLOAD_ERR_OK) {

				//store new video
				$video = $this->videoService->storeUpload(ilObject::_lookupObjectId($this->getCurrentRefId()));
				$block
					->setPath($video->getVideoPath())
					->setCoverPath($video->getCoverPath());

				//delete old video
				$oldVideo = new VideoModel();
				$oldVideo
					->setVideoPath($oldVideoBlock->getPath())
					->setCoverPath($oldVideoBlock->getCoverPath());
				$this->videoService->delete($oldVideo);
			}

			$this->videoBlockService->store($block);

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

	private function delete() {
		$queries = $this->request->getQueryParams();
		$blockId = intval($queries[self::BLOCK_ID_QUERY_KEY]);
		$this->redirectInvalidRequests($blockId);
		$this->videoBlockService->delete($blockId);
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