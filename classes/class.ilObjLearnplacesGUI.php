<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use SRAG\Learnplaces\container\PluginContainer;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;

/**
 * Class ilObjLearnplacesGUI
 *
 * @author            Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy ilObjLearnplacesGUI: ilRepositoryGUI, ilObjPluginDispatchGUI
 * @ilCtrl_isCalledBy ilObjLearnplacesGUI: ilAdministrationGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: ilCommonActionDispatcherGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlPictureUploadBlockGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlContentGUI
 */
class ilObjLearnplacesGUI extends ilObjectPluginGUI {

	const DEFAULT_CMD = CommonControllerAction::CMD_INDEX;


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
		$this->renderTabs();
		switch ($nextClass) {
			case "":
			case strtolower(static::class):
				parent::executeCommand();
				break;
			case strtolower(xsrlContentGUI::class):
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlContentGUI::class));
				break;
			case strtolower(xsrlPictureUploadBlockGUI::class):
				$this->ctrl->forwardCommand(PluginContainer::resolve(xsrlPictureUploadBlockGUI::class));
				break;
			default:
				$this->ctrl->redirectByClass(static::class);
				break;
		}
	}


	/**
	 * @param $cmd string of command which should be
	 */
	public function performCommand($cmd) {
		if (!$this->access->checkAccess('read', $cmd, $this->user->getId())) {
			$this->{$cmd}();
		}
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
		$this->tabs->addTab(xsrlContentGUI::class, $this->plugin->txt('tabs_content'), $this->ctrl->getLinkTargetByClass(xsrlContentGUI::class, self::DEFAULT_CMD));
		$this->tabs->addTab(xsrlContentGUI::class, $this->plugin->txt('tabs_settings'), $this->ctrl->getLinkTargetByClass(xsrlContentGUI::class, self::DEFAULT_CMD));
	}


}