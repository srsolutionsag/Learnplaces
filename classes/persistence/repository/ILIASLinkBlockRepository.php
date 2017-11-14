<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\ILIASLinkBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface ILIASLinkBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface ILIASLinkBlockRepository {

	/**
	 * Updates an ILIAS link block or creates a new one if the block id was not found.
	 *
	 * @param ILIASLinkBlock $linkBlock     The ILIAS link block which should be stored.
	 *
	 * @return ILIASLinkBlock               The newly created or updated ILIAS link block.
	 */
	public function store(ILIASLinkBlock $linkBlock): ILIASLinkBlock;


	/**
	 * Searches an ILIAS link block by id.
	 *
	 * @param int $id           The id which should be used to search a block.
	 *
	 * @return ILIASLinkBlock   The found ILIAS link block.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if no ILIAS link block was not found with the given id.
	 */
	public function findByBlockId(int $id): ILIASLinkBlock;


	/**
	 * Deletes an ILIAS link block with the given id.
	 *
	 * @param int $id   The id of the ILIAS link block which should be deleted.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the given ILIAS link block id was not found.
	 */
	public function delete(int $id);


	public function findByLearnplace(Learnplace $learnplace): array;
}