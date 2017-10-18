<?php

namespace SRAG\Learnplaces\gui\helper;

/**
 * Class Ctrl
 *
 * Provides base fucntionality which is needed when implementing controller classes in ILIAS using
 * ilCtrl
 *
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
abstract class Ctrl {

	use DIC;
	const CMD_INDEX = "index";
	const CMD_ADD = "add";
	const CMD_CREATE = "create";
	const CMD_EDIT = "edit";
	const CMD_UPDATE = "update";
	const CMD_CONFIRM = "confirm";
	const CMD_DELETE = "delete";
	const CMD_CANCEL = "cancel";
	const AR_ID = "arid";
	/**
	 * @var \SRAG\Learnplaces\helper\Ctrl
	 */
	protected $parent_gui = null;


	/**
	 * @return \SRAG\Learnplaces\helper\Ctrl
	 */
	public function getParentGui() {
		return $this->parent_gui;
	}


	/**
	 * @param \SRAG\Learnplaces\helper\Ctrl $parent_gui
	 */
	public function setParentGui($parent_gui) {
		$this->parent_gui = $parent_gui;
	}


	abstract protected function index();


	/**
	 * @return array of GUI_Class-Names
	 */
	protected function getPossibleNextClasses() {
		return array();
	}


	/**
	 * @return null|string of active Tab
	 */
	protected function getActiveTabId() {
		return null;
	}


	protected function cancel() {
		$this->ctrl()->redirect($this, self::CMD_INDEX);
	}


	/***
	 * @param $html
	 */
	protected function setContent($html) {
		$this->tpl()->setContent($html);
	}


	public function executeCommand() {
		$this->dic()->language()->loadLanguageModule("orgu");
		$cmd = $this->dic()->ctrl()->getCmd(self::CMD_INDEX);
		$next_class = $this->dic()->ctrl()->getNextClass();
		if ($next_class) {
			foreach ($this->getPossibleNextClasses() as $class) {
				if (strtolower($class) === $next_class) {
					$instance = new $class();
					if ($instance instanceof Ctrl) {
						$instance->setParentGui($this);
						$this->ctrl()->forwardCommand($instance);
					}

					return;
				}
			}
		}

		if ($this->getActiveTabId()) {
			$this->tabs()->activateTab($this->getActiveTabId());
		}

		switch ($cmd) {
			default:
				if ($this->checkRequestReferenceId()) {
					$this->{$cmd}();
				}
				break;
		}
	}


	/**
	 * @param $subtab_id
	 * @param $url
	 */
	protected function pushSubTab($subtab_id, $url) {
		$this->tabs()->addSubTab($subtab_id, $this->txt($subtab_id), $url);
	}


	/**
	 * @param $subtab_id
	 */
	protected function activeSubTab($subtab_id) {
		$this->tabs()->activateSubTab($subtab_id);
	}


	protected function checkRequestReferenceId() {
		/**
		 * @var $ilAccess \ilAccessHandler
		 */
		$ref_id = $this->getParentRefId();
		if ($ref_id) {
			return $this->dic()->access()->checkAccess("read", "", $ref_id);
		}

		return true;
	}


	/**
	 * @return int|null
	 */
	protected function getParentRefId() {
		try {
			$http = $this->dic()->http();
			$ref_id = $http->request()->getQueryParams()["ref_id"];
		} catch (\Exception $e) {
			$ref_id = $_GET['ref_id'];
		}

		return $ref_id;
	}
}
