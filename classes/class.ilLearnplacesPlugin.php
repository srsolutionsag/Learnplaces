<?php
require_once __DIR__ . '/bootstrap.php';

/**
 * Class ilLearnplacesPlugin
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilLearnplacesPlugin extends ilRepositoryObjectPlugin {

	const PLUGIN_NAME = "Learnplaces";
	const PLUGIN_ID = "xsrl";
	/**
	 * @var ilLearnplacesPlugin $instance
	 */
	private static $instance;


	/**
	 * ilLearnplacesPlugin constructor.
	 */
	public function __construct() {
		parent::__construct();

		self::$instance = $this;
	}


	public static function getInstance() {
		if(is_null(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}

	public function getPluginName() {
		return self::PLUGIN_NAME;
	}


	protected function uninstallCustom() {
		throw new Exception("Not Implemented yet.");
	}
}