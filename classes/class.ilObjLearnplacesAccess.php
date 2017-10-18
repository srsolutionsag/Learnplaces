<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilObjLearnLoc2Access
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilObjLearnplacesAccess extends ilObjectPluginAccess {

	/**
	 * @var \ILIAS\DI\Container
	 */
	private $dic;


	/**
	 * ilObjLearnLoc2Access constructor.
	 */
	public function __construct() {
		parent::__construct();

		global $DIC;
		$this->dic = $DIC;
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

		$ilUser = $this->dic["ilUser"];
		$ilAccess = $this->dic["ilAccess"];

		if ($a_user_id == "") {
			$a_user_id = $ilUser->getId();
		}
		switch ($a_permission) {
			case "read":
				if (!self::checkOnline($a_obj_id)
				    && !$ilAccess->checkAccessOfUser($a_user_id, "write", "", $a_ref_id)) {
					return false;
				}
				break;
		}

		return true;
	}


	public static function checkOnline($objectId) {
		throw new Exception("Not implemented yet");
	}
}