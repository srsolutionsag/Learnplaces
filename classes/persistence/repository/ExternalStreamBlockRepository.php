<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\ExternalStreamBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface ExternalStreamBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface ExternalStreamBlockRepository {

	/**
	 * Updates an external stream block or creates a new one if the block id was not found.
	 *
	 * @param ExternalStreamBlock $streamBlock  The external stream block which should be created or updated.
	 *
	 * @return ExternalStreamBlock              The newly updated or created external stream block.
	 */
	public function store(ExternalStreamBlock $streamBlock): ExternalStreamBlock;


	/**
	 * Searches an external stream block by block id.
	 *
	 * @param int $id               The id of the block which should be used to search after the external stream block.
	 *
	 * @return ExternalStreamBlock  The external stream block with the given block id.
	 * @throws EntityNotFoundException
	 *                              Thrown if external stream block was found with the given id.
	 */
	public function findByBlockId(int $id): ExternalStreamBlock;


	/**
	 * Deletes an external stream block with the given id.
	 *
	 * @param int $id   The id of the block which should be deleted.
	 *
	 * @return void
	 * @throws EntityNotFoundException
	 *                  Thrown if no block was found with the given id.
	 */
	public function delete(int $id);


	/**
	 * Searches all external stream blocks which belong to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search all corresponding external stream blocks.
	 *
	 * @return ExternalStreamBlock[]    All external stream blocks which belong to the given learnplace.
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}