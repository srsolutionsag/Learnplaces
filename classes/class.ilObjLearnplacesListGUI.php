<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilObjLearnLoc2ListGUI
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilObjLearnplacesListGUI extends ilObjectPluginListGUI {

	function getGuiClass() {
		return ilObjLearnplacesGUI::class;
	}


	function initCommands() {
		return [];
	}


	function initType() {
		$this->setType(ilLearnplacesPlugin::PLUGIN_ID);
	}
}