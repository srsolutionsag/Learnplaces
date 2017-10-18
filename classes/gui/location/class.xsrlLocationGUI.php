<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use SRAG\Learnplaces\gui\helper\CtrlAware;
use SRAG\Learnplaces\gui\helper\ICtrlAware;

/**
 * Class xsrlLocationGUI
 *
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class xsrlLocationGUI implements ICtrlAware {

	use CtrlAware;


	public function index() {
		$this->setTitle("xsrlLocationGUI");
		$this->setContent("xsrlLocationGUI");
	}
}
