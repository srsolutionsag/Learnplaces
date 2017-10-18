<?php

namespace SRAG\Learnplaces\gui\helper;

/**
 * Class ICtrlAware
 *
 * Provides base functionality which is needed when implementing controller classes in ILIAS using
 * ilCtrl
 *
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
interface ICtrlAware {

	const CMD_INDEX = "index";
	const CMD_ADD = "add";
	const CMD_CREATE = "create";
	const CMD_EDIT = "edit";
	const CMD_UPDATE = "update";
	const CMD_CONFIRM = "confirm";
	const CMD_DELETE = "delete";
	const CMD_CANCEL = "cancel";
	const AR_ID = "arid";


	public function executeCommand();


	/**
	 * @return ICtrlAware
	 */
	public function getParentController();


	/**
	 * @param ICtrlAware $ctrlAware
	 */
	public function setParentController(ICtrlAware $ctrlAware);


	public function index();


	public function cancel();
}
