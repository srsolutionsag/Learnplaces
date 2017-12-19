<?php

namespace SRAG\Learnplaces\service\security;

/**
 * Interface BlockAccessGuard
 *
 * The block access guard must be used to validate the relation
 * of the block to the current ref id.
 *
 * @package SRAG\Learnplaces\service\security
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface BlockAccessGuard {

	/**
	 * Validates that the block belongs to the current object id.
	 * If this method returns false, a malicious user tried to inject block ids over a ref id which belongs to
	 * a different learnplace to mitigate the rbac checks.
	 *
	 * @param int $blockId  The block id which should be checked.
	 *
	 * @return bool         True if the block belongs to the current object otherwise false.
	 */
	public function isValidBlockReference(int $blockId): bool;

}