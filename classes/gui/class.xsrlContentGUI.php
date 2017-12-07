<?php
declare(strict_types=1);

use ILIAS\HTTP\GlobalHttpState;
use SRAG\Learnplaces\gui\block\BlockAddFormGUI;
use SRAG\Learnplaces\gui\block\BlockType;
use SRAG\Learnplaces\gui\block\PictureUploadBlockEditFormView;
use SRAG\Learnplaces\gui\block\RenderableBlockViewFactory;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\PictureUploadBlockModel;

/**
 *
 *
 * Wie https://git.studer-raimann.ch/ILIAS/Core/blob/feature/5-4/bibliographic-improvements/Modules/Bibliographic/classes/FieldFilter/class.ilBiblFieldFilterGUI.php
 *
 *
 * Class xsrlContentGUI
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class xsrlContentGUI {

	const TAB_ID = 'content';

	private static $blockTypeViewMapping = [
		BlockType::PICTURE_UPLOAD => xsrlPictureUploadBlockGUI::class,
	];

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
	 * @var RenderableBlockViewFactory $renderableFactory
	 */
	private $renderableFactory;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;


	/**
	 * xsrlContentGUI constructor.
	 *
	 * @param ilTabsGUI                  $tabs
	 * @param ilTemplate                 $template
	 * @param ilCtrl                     $controlFlow
	 * @param ilAccessHandler            $access
	 * @param GlobalHttpState            $http
	 * @param ilLearnplacesPlugin        $plugin
	 * @param RenderableBlockViewFactory $renderableFactory
	 * @param LearnplaceService          $learnplaceService
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilAccessHandler $access, GlobalHttpState $http, ilLearnplacesPlugin $plugin, RenderableBlockViewFactory $renderableFactory, LearnplaceService $learnplaceService) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->access = $access;
		$this->http = $http;
		$this->plugin = $plugin;
		$this->renderableFactory = $renderableFactory;
		$this->learnplaceService = $learnplaceService;
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

	//actions
	private function index() {
		$toolbar = new ilToolbarGUI();
		$buttonAdd = ilLinkButton::getInstance();
		$buttonAdd->setUrl($this->controlFlow->getLinkTarget($this, CommonControllerAction::CMD_ADD));
		$buttonAdd->setCaption($this->plugin->txt('common_add'), false);
		$toolbar->addStickyItem($buttonAdd);

		$template = new ilTemplate('./Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces/templates/default/tpl.block_list.html', true, true);
		$template->setVariable('TOOLBAR', $toolbar->getHTML());

		$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));

		$blockHtml = '';
		foreach ($learnplace->getBlocks() as $block) {
			try {
				$view = $this->renderableFactory->getInstance($block);
				$blockHtml .= $view->getHtml();
			}
			catch (InvalidArgumentException $ex) {
				//only temporary unitl all blocks are implemented
			}
		}
		$template->setVariable('CONTENT', $blockHtml);
		$this->template->setContent($template->get());
	}

	private function add() {
		$form = new BlockAddFormGUI();
		$this->template->setContent($form->getHTML());
	}

	private function create() {
		$blockAdd = new BlockAddFormGUI();
		if($blockAdd->checkInput()) {
			$input = intval($blockAdd->getInput(BlockAddFormGUI::POST_BLOCK_TYPES, true));
			$controller = static::$blockTypeViewMapping[$input];

			//dispatch to controller which knows how to handle that block
			$this->controlFlow->redirectByClass($controller, CommonControllerAction::CMD_ADD);
			return;
		}

		ilUtil::sendFailure($this->plugin->txt('message_create_failure'), true);
		$this->controlFlow->redirect($this, CommonControllerAction::CMD_INDEX);
	}

	private function cancel() {
		$this->controlFlow->redirect($this, CommonControllerAction::CMD_INDEX);
	}



}