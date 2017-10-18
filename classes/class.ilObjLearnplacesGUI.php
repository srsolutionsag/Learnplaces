<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SRAG\Learnplaces\gui\helper\CtrlHandler;
use SRAG\Learnplaces\gui\helper\ICtrlAware;

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
 * @ilCtrl_Calls      ilObjLearnplacesGUI: xsrlLocationGUI
 */
class ilObjLearnplacesGUI extends ilObjectPluginGUI implements ICtrlAware {

	use CtrlHandler;
	const DEFAULT_CMD = ICtrlAware::CMD_INDEX;


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
		$nextClass = $this->ctrl()->getNextClass();
		switch ($nextClass) {
			case "":
			case strtolower(static::class):
				parent::executeCommand();
				break;
			default:
				$this->handleNextClass($this);
				break;
		}
	}


	/**
	 * @inheritdoc
	 */
	public function getPossibleNextClasses() {
		return array(
			xsrlBlockGUI::class,
			xsrlLocationGUI::class,
		);
	}


	public function getParentController() {
		return $this;
	}


	public function setParentController(ICtrlAware $ctrlAware) {
		// TODO: Implement setParentController() method.
	}


	/**
	 * @param $cmd string of command which should be
	 */
	public function performCommand($cmd) {
		if (!$this->access()->checkAccess('read', '', $this->user()->getId())) {
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
		$this->ctrl()->redirectByClass((new \ReflectionClass(xsrlLocationGUI::class))->getShortName());
	}

	//
	// DIC Helper
	//

	/**
	 * @return \ILIAS\DI\Container
	 */
	private function dic() {
		return $GLOBALS['DIC'];
	}


	/**
	 * @return \ilAccessHandler
	 */
	public function access() {
		return $this->dic()->access();
	}


	/**
	 * @return \ilCtrl
	 */
	public function ctrl() {
		return $this->dic()->ctrl();
	}


	/**
	 * @return \ilTemplate
	 */
	public function tpl() {
		return $this->dic()->ui()->mainTemplate();
	}


	/**
	 * @return \ilObjUser
	 */
	public function user() {
		return $this->dic()->user();
	}


	/**
	 * @return \ilLanguage
	 */
	public function language() {
		return $this->dic()->language();
	}


	/**
	 * @return \ilTabsGUI
	 */
	public function tabs() {
		return $this->dic()->tabs();
	}
}