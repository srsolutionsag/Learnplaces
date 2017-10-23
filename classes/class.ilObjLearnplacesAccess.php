<?php

use SRAG\Learnplaces\gui\helper\DIC;

require_once __DIR__ . '/bootstrap.php';

/**
 * Class ilObjLearnplacesAccess
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilObjLearnplacesAccess extends ilObjectPluginAccess {

	use DIC {
		DIC::__construct as private traitConstructor;
	}


	/**
	 * ilObjLearnLoc2Access constructor.
	 */
	public function __construct() {
		$this->initFromDIC($GLOBALS['DIC']);
	}


	/**
	 * Checks wether a user may invoke a command or not
	 * (this method is called by ilAccessHandler::checkAccess)
	 *
	 * Please do not check any preconditions handled by
	 * ilConditionHandler here. Also don't do usual RBAC checks.
	 *
	 * @param    string $a_cmd        command (not permission!)
	 * @param    string $a_permission permission
	 * @param    int    $a_ref_id     reference id
	 * @param    int    $a_obj_id     object id
	 * @param    string $a_user_id    user id (if not provided, current user is taken)
	 *
	 * @return    boolean        true, if everything is ok
	 */
	public function _checkAccess($a_cmd, $a_permission, $a_ref_id, $a_obj_id, $a_user_id = "") {
		return true; //TODO

		if ($a_user_id == "") {
			$a_user_id = $this->user()->getId();
		}
		switch ($a_permission) {
			case "read":
				if (!self::checkOnline($a_obj_id)
				    && !$this->access()->checkAccessOfUser($a_user_id, "write", "", $a_ref_id)) {
					return false;
				}
				break;
		}

		return true;
	}


	/**
	 * @param $object_id
	 *
	 * @throws \Exception
	 */
	public static function checkOnline($object_id) {
		return true;
		throw new Exception("Not implemented yet");
	}
}