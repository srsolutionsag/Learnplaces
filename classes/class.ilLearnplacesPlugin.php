<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilLearnLoc2Plugin
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilLearnplacesPlugin extends ilRepositoryObjectPlugin {

	const PLUGIN_NAME = "Learnplaces";
	const PLUGIN_ID = "xsrl";


	public function getPluginName() {
		return self::PLUGIN_NAME;
	}


	protected function uninstallCustom() {
		throw new Exception("Not Implemented yet.");
	}
}