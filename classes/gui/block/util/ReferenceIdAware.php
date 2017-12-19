<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\util;

use ilAccessHandler;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Trait ReferenceIdAware
 *
 * @package SRAG\Learnplaces\gui\block\util
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait ReferenceIdAware {

	/**
	 * @var ilAccessHandler $access
	 */
	private $access;
	/**
	 * @var ServerRequestInterface $request
	 */
	private $request;


	/**
	 * Check the given permission of the current user for the current reference id.
	 *
	 * @param string $permission    The permission which should be checked for the current user.
	 *
	 * @return bool                 True if the permission is ok for the current reference id, otherwise false.
	 */
	private function checkRequestReferenceId(string $permission) {
		/**
		 * @var $ilAccess \ilAccessHandler
		 */
		$ref_id = $this->getCurrentRefId();
		if ($ref_id > 0) {
			return $this->access->checkAccess($permission, '', $ref_id);
		}

		return false;
	}

	private function getCurrentRefId(): int {
		$queries = $this->request->getQueryParams();
		return intval($queries["ref_id"]);
	}
}