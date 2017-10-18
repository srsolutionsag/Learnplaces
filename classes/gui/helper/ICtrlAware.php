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


	/**
	 * @return array of ClassNames this Controller can call using ILIAS ilCtrl
	 */
	public function getPossibleNextClasses();


	/**
	 * @return \ilCtrl
	 */
	public function ctrl();


	/**
	 * @return \ilTemplate the global Instance
	 */
	public function tpl();


	/**
	 * @return \ilLanguage
	 */
	public function language();


	/**
	 * @return \ilTabsGUI
	 */
	public function tabs();


	/**
	 * @return \ilObjUser
	 */
	public function user();


	/**
	 * @return \ilAccessHandler
	 */
	public function access();


	/**
	 * @param \SRAG\Learnplaces\gui\helper\ICtrlAware $ctrlAware the current controller
	 *
	 * @return bool whether a next class has handled the request or not
	 */
	public function handleNextClass(ICtrlAware $ctrlAware);
}
