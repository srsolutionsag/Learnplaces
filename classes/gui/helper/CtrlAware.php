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

	use CtrlHandler ;
	use DIC;
	/**
	 * @var ICtrlAware
	 */
	protected $parent_gui = null;


	/**
	 * Ctrl constructor.
	 */
	public function __construct(\ilCtrl $ctrl, \ilTemplate $tpl, \ilLanguage $lng, \ilTabsGUI $tabs, \ilObjUser $user, \ilAccessHandler $access) {
		$this->ctrl = $ctrl;
		$this->tpl = $tpl;
		$this->language = $lng;
		$this->tabs = $tabs;
		$this->user = $user;
		$this->access = $access;
	}


	public function executeCommand() {
		if ($this->handleNextClass($this)) {
			return true;
		}
		$this->tpl()->getStandardTemplate();
		$cmd = $this->ctrl()->getCmd(ICtrlAware::CMD_INDEX);
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
		$this->tpl()->show();

		return true;
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
