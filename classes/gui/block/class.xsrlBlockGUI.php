<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use SRAG\Learnplaces\gui\helper\CtrlAware;
use SRAG\Learnplaces\gui\helper\ICtrlAware;

/**
 * Class xsrlBlockGUI
 *
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class xsrlBlockGUI implements ICtrlAware {

	use CtrlAware;


	public function index() {
		$this->setTitle("LOREM");
		$this->setContent("LOREM");
	}
}
