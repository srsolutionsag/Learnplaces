<?php

use SRAG\Learnplaces\gui\helper\DIC;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilObjLearnplacesGUI
 *
 * @author            Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy ilObjLearnplacesGUI: ilRepositoryGUI, ilObjPluginDispatchGUI
 * @ilCtrl_isCalledBy ilObjLearnplacesGUI: ilAdministrationGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI
 * @ilCtrl_Calls      ilObjLearnplacesGUI: ilCommonActionDispatcherGUI
 */
class ilObjLearnplacesGUI extends ilObjectPluginGUI {

	use DIC;


	/**
	 * @inheritDoc
	 */
	public function getType() {
		return ilLearnplacesPlugin::PLUGIN_ID;
	}


	/**
	 * This command will be executed after a new repository object was created.
	 *
	 * @return string
	 */
	public function getAfterCreationCmd() {
		return \SRAG\Learnplaces\gui\helper\Ctrl::CMD_INDEX;
	}


	/**
	 * This command will be executed if no command was supplied.
	 *
	 * @return string
	 */
	public function getStandardCmd() {
		return \SRAG\Learnplaces\gui\helper\Ctrl::CMD_INDEX;
	}


	protected function index() {
		throw new Exception('Not implemented');
	}
}