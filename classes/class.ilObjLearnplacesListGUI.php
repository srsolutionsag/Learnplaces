<?php

require_once __DIR__ . '/bootstrap.php';

use SRAG\Learnplaces\gui\helper\ICtrlAware;

/**
 * Class ilObjLearnplacesListGUI
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilObjLearnplacesListGUI extends ilObjectPluginListGUI {

	/**
	 * @return string
	 */
	public function getGuiClass() {
		return ilObjLearnplacesGUI::class;
	}


	/**
	 * @return array
	 */
	public function getCommands() {
		return parent::getCommands();
	}


	/**
	 * @return array
	 */
	public function initCommands() {
		// Always set
		$this->timings_enabled = false;
		$this->subscribe_enabled = false;
		$this->payment_enabled = false;
		$this->link_enabled = false;
		$this->info_screen_enabled = true;
		$this->delete_enabled = true;

		// Should be overwritten according to status
		$this->cut_enabled = false;
		$this->copy_enabled = false;

		$commands = array(
			array(
				'permission' => 'read',
				'cmd'        => ICtrlAware::CMD_INDEX,
				'default'    => true,
			),
		);

		return $commands;
	}


	public function initType() {
		$this->setType(ilLearnplacesPlugin::PLUGIN_ID);
	}
}