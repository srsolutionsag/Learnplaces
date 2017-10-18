<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SRAG\Learnplaces\gui\helper\CtrlAware;
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
 */
class ilObjLearnplacesGUI extends ilObjectPluginGUI {

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
				$this->handleNextClass();
				break;
		}
	}


	protected function handleNextClass() {
		$this->tpl()->getStandardTemplate();
		/**
		 * @var $nextClass CtrlAware
		 */
		$nextClass = (string)$this->ctrl()->getNextClass();
		$fqClassName = null;
		switch ($nextClass) {
			case strtolower(xsrlBlockGUI::class):
				$fqClassName = xsrlBlockGUI::class;
				break;
		}
		$instance = new $fqClassName($this->ctrl(), $this->tpl(), $this->language(), $this->tabs(), $this->user(), $this->access());
		$this->ctrl()->forwardCommand($instance);
		$this->tpl()->show();
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
		$this->ctrl()->redirectByClass((new \ReflectionClass(xsrlBlockGUI::class))->getShortName());
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
	protected function access() {
		return $this->dic()->access();
	}


	/**
	 * @return \ilCtrl
	 */
	protected function ctrl() {
		return $this->dic()->ctrl();
	}


	/**
	 * @return \ilTemplate
	 */
	protected function tpl() {
		return $this->dic()->ui()->mainTemplate();
	}


	/**
	 * @return \ilObjUser
	 */
	protected function user() {
		return $this->dic()->user();
	}


	/**
	 * @return \ilLanguage
	 */
	protected function language() {
		return $this->dic()->language();
	}


	/**
	 * @return \ilTabsGUI
	 */
	protected function tabs() {
		return $this->dic()->tabs();
	}
}