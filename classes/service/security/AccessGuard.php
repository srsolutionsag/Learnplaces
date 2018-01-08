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
interface AccessGuard {

	const PERMISSION_READ = 'read';
	const PERMISSION_WRITE = 'write';

	/**
	 * Validates that the block belongs to the current object id.
	 * If this method returns false, a malicious user tried to inject block ids over a ref id which belongs to
	 * a different learnplace to mitigate the rbac checks.
	 * The second cause could be that a user tried to access blocks which he can't see due to visibility restrictions.
	 *
	 * @param int $blockId  The block id which should be checked.
	 *
	 * @return bool         True if the block belongs to the current object otherwise false.
	 */
	public function isValidBlockReference(int $blockId): bool;


	/**
	 * Checks whether the current user has read permissions or not for the current ref id.
	 *
	 * @return bool True if the user has read access for the current ref id, otherwise false.
	 */
	public function hasReadPermission(): bool;


	/**
	 * Checks whether the current user has write permissions or not for the current ref id.
	 *
	 * @return bool True if the user has write access for the current ref id, otherwise false.
	 */
	public function hasWritePermission(): bool;

}