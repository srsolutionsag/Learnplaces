<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use SRAG\Learnplaces\container\PluginContainer;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\MapBlockService;
use SRAG\Learnplaces\service\publicapi\model\ILIASLinkBlockModel;
use SRAG\Learnplaces\service\publicapi\model\MapBlockModel;
use SRAG\Learnplaces\service\security\AccessGuard;
use SRAG\Learnplaces\service\visibility\LearnplaceServiceDecoratorFactory;

/**
 * Class ilObjLearnplacesGUI
 *
 * @author            Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy ilObjLearnplacesGUI: ilRepositoryGUI, ilObjPluginDispatchGUI
 * @ilCtrl_isCalledBy ilObjLearnplacesGUI: ilAdministrationGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: ilCommonActionDispatcherGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlPictureUploadBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlPictureBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlContentGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlRichTextBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlIliasLinkBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlMapBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlVideoBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlAccordionBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlSettingGUI
 */
final class ilObjLearnplacesGUI extends ilObjectPluginGUI {

	const DEFAULT_CMD = CommonControllerAction::CMD_INDEX;
	const TAB_ID_PERMISSION = 'id_permissions';
	/**
	 * @var MapBlockService $mapBlockService
	 */
	private $mapBlockService;
	/**
	 * @var int $objectId
	 */
	private $objectId;
	/**
	 * @var ilTabsGUI $learnplaceTabs
	 */
	private $learnplaceTabs;
	/**
	 * @var AccessGuard $accessGuard
	 */
	private $accessGuard;
	/**
	 * @var ilObjUser $currentUser
	 */
	private $currentUser;


	/**
	 * ilObjLearnplacesGUI constructor.
	 *
	 * @param int|null  $a_ref_id
	 * @param int       $a_id_type
	 * @param int       $a_parent_node_id
	 *
	 * @see ilObjectPluginGUI for possible id types.
	 */
	public function __construct($a_ref_id = 0, int $a_id_type = self::REPOSITORY_NODE_ID, int $a_parent_node_id = 0) {
		parent::__construct($a_ref_id, $a_id_type, $a_parent_node_id);
		$this->mapBlockService = PluginContainer::resolve(MapBlockService::class);
		$this->objectId = intval(ilObject::_lookupObjectId($this->ref_id));
		$this->learnplaceTabs = PluginContainer::resolve('ilTabs');
		$this->accessGuard = PluginContainer::resolve(AccessGuard::class);
		$this->currentUser = PluginContainer::resolve('ilUser');
	}


	/**
	 * @inheritDoc
	 */
	public function getType() {
		return ilLearnplacesPlugin::PLUGIN_ID;
	}


	/**
	 * Main Triage to following GUI-Classes
	 */
	public function executeCommand() {
		$nextClass = $this->ctrl->getNextClass();

		/**
		 * @var ilTemplate $template
		 */
		$template = PluginContainer::resolve('tpl');
		$template->setTitle(ilObject::_lookupTitle($this->objectId));
		$template->setDescription(ilObject::_lookupDescription($this->objectId));
		$template->setTitleIcon(ilObject::_getIcon($this->objectId));
		$this->setLocator();
		$properties = [];

		if(!ilObjLearnplacesAccess::checkOnline(intval($this->obj_id))) {
			$properties[] = [
				'property' => $this->txt('common_status'),
				'value' => $this->txt('common_offline'),
			];
		}
		$template->setAlertProperties($properties);

		switch ($nextClass) {
			case "":
			case strtolower(static::class):
				parent::executeCommand();
				break;
			case strtolower(xsrlContentGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlContentGUI::class));
				break;
			case strtolower(xsrlPictureUploadBlockGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlPictureUploadBlockGUI::class));
				break;
			case strtolower(xsrlPictureBlockGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlPictureBlockGUI::class));
				break;
			case strtolower(xsrlRichTextBlockGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlRichTextBlockGUI::class));
				break;
			case strtolower(xsrlIliasLinkBlockGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlIliasLinkBlockGUI::class));
				break;
			case strtolower(xsrlIliasLinkBlockEditFormViewGUI::class):
				//required for the ilLinkInputGUI ...
				$this->ctrl->forwardCommand(new xsrlIliasLinkBlockEditFormViewGUI(new ILIASLinkBlockModel()));
				break;
			case strtolower(xsrlMapBlockGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlMapBlockGUI::class));
				break;
			case strtolower(xsrlVideoBlockGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlVideoBlockGUI::class));
				break;
			case strtolower(xsrlAccordionBlockGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlAccordionBlockGUI::class));
				break;
			case strtolower(xsrlSettingGUI::class):
				$this->renderTabs();
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlSettingGUI::class));
				break;
			case strtolower(ilPermissionGUI::class):
				$this->renderTabs();
				$this->learnplaceTabs->activateTab(self::TAB_ID_PERMISSION);
				$this->ctrl->forwardCommand(new ilPermissionGUI($this));
				$template->getStandardTemplate();
				$template->show();
				break;
			default:
				$this->ctrl->redirectByClass(static::class, $this->getStandardCmd());
				break;
		}
	}

	protected function performCommand(string $command) {
		if($this->accessGuard->hasReadPermission()) {
			switch ($command) {
				case CommonControllerAction::CMD_INDEX:
					$this->index();
					return;
			}
		}

		$this->ctrl->redirectByClass(ilRepositoryGUI::class, $this->getStandardCmd());
	}

	/**
	 * This command will be executed after a new repository object was created.
	 *
	 * @return string
	 */
	public function getAfterCreationCmd() {
		return self::DEFAULT_CMD;
	}


	/**
	 * This command will be executed if no command was supplied.
	 *
	 * @return string
	 */
	public function getStandardCmd() {
		return self::DEFAULT_CMD;
	}


	public function index() {
		$this->ctrl->redirectByClass(xsrlContentGUI::class, self::DEFAULT_CMD);
	}

	private function renderTabs() {
		$this->learnplaceTabs->addTab(xsrlContentGUI::TAB_ID, $this->plugin->txt('tabs_content'), $this->ctrl->getLinkTargetByClass(xsrlContentGUI::class, self::DEFAULT_CMD));
		if($this->hasMap())
			$this->learnplaceTabs->addTab(xsrlMapBlockGUI::TAB_ID, $this->plugin->txt('tabs_map'), $this->ctrl->getLinkTargetByClass(xsrlMapBlockGUI::class, self::DEFAULT_CMD));
		if($this->accessGuard->hasWritePermission()) {
			$this->learnplaceTabs->addTab(xsrlSettingGUI::TAB_ID, $this->plugin->txt('tabs_settings'), $this->ctrl->getLinkTargetByClass(xsrlSettingGUI::class, CommonControllerAction::CMD_EDIT));
		}
		parent::setTabs();

		//add an empty tab to prevent ilias from hiding the entire tab bar if only one tab exists.
		$this->learnplaceTabs->addTab('', '', '#');
	}

	private function hasMap(): bool {
		if(is_null($this->ref_id))
			return false;

		try {
			$map = $this->mapBlockService->findByObjectId(ilObject::_lookupObjectId($this->ref_id));
			return $this->accessGuard->isValidBlockReference($map->getId());
		}
		catch (InvalidArgumentException $ex) {
			return false;
		}
	}
}