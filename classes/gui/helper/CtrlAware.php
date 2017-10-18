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
trait CtrlAware {

	use DIC;
	/**
	 * @var ICtrlAware
	 */
	protected $parent_gui = null;


	public function executeCommand() {
		$this->language()->loadLanguageModule("orgu");
		$cmd = $this->ctrl()->getCmd(ICtrlAware::CMD_INDEX);
		$next_class = $this->ctrl()->getNextClass();
		if ($next_class) {
			foreach ($this->getPossibleNextClasses() as $class) {
				if (strtolower($class) === $next_class) {
					/**
					 * @var $instance CtrlAware
					 */
					$instance = new $class($this->ctrl(), $this->tpl(), $this->language(), $this->tabs(), $this->user(), $this->access());
					if ($instance instanceof ICtrlAware) {
						$instance->setParentController($this);
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
	 * @return ICtrlAware
	 */
	public function getParentController() {
		return $this->parent_gui;
	}


	/**
	 * @param ICtrlAware $ctrlAware
	 */
	public function setParentController(ICtrlAware $ctrlAware) {
		$this->parent_gui = $ctrlAware;
	}


	/**
	 * @return array of GUI_Class-Names which use CtrlAware
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


	public function cancel() {
		$this->ctrl()->redirect($this, ICtrlAware::CMD_INDEX);
	}


	/***
	 * @param $html
	 */
	protected function setContent($html) {
		$this->tpl()->setContent($html);
	}


	/***
	 * @param $title
	 */
	protected function setTitle($title) {
		$this->tpl()->setTitle($title);
	}


	/**
	 * @param $subtab_id
	 * @param $url
	 */
	protected function pushSubTab($subtab_id, $url) {
		$this->tabs()->addSubTab($subtab_id, $this->lang()->txt($subtab_id), $url);
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
		$ref_id = $this->getCurrentRefId();
		if ($ref_id) {
			return $this->dic()->access()->checkAccess("read", "", $ref_id);
		}

		return true;
	}
}
