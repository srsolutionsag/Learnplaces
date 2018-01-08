<?php

namespace SRAG\Learnplaces\persistence\repository;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\dto\AccordionBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface AccordionBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface AccordionBlockRepository {

	/**
	 * Updates an existing accordion block or creates a new one if the accordion block id does not exist.
	 *
	 * @param AccordionBlock $accordionBlock    The accordion block which should be created or updated.
	 *
	 * @return AccordionBlock                   The newly created or updated accordion block.
	 */
	public function store(AccordionBlock $accordionBlock): AccordionBlock;


	/**
	 * Searches an accordion block by block id.
	 *
	 * @param int $id           The id of the accordion block which should be found.
	 *
	 * @return AccordionBlock   The accordion block with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if the accordion block with the given id was not found.
	 */
	public function findByBlockId(int $id): AccordionBlock;


	/**
	 * Deletes an accordion block by id.
	 *
	 * @param int $id   The id of the accordion block which should be deleted.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the accordion block with the given was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches all accordion blocks which belong to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search all corresponding accordion blocks.
	 *
	 * @return AccordionBlock[]         All accordion blocks which belong to the given learnplace.
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}