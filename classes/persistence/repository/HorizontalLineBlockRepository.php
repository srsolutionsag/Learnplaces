<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\HorizontalLineBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface HorizontalLineBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface HorizontalLineBlockRepository {

	/**
	 * Updates the horizontal line block or creates a new one if the block id was not found.
	 *
	 * @param HorizontalLineBlock $lineBlock    The horizontal line block which should be updated or created.
	 *
	 * @return HorizontalLineBlock              The updated or created horizontal line block.
	 */
	public function store(HorizontalLineBlock $lineBlock): HorizontalLineBlock;


	/**
	 * Searches a horizontal line block by block id.
	 *
	 * @param int $id               The block id which should be used to search for the horizontal line block.
	 *
	 * @return HorizontalLineBlock  The found horizontal line block.
	 *
	 * @throws EntityNotFoundException
	 *                              Thrown if the horizontal line block was not found with the given id.
	 */
	public function findByBlockId(int $id): HorizontalLineBlock;


	/**
	 * Deletes a horizontal line block by id.
	 *
	 * @param int $id   The id of the horizontal line block which should be deleted.
	 *
	 * @return void
	 */
	public function delete(int $id);


	/**
	 * Searches all horizontal line blocks which belongs to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search all corresponding blocks.
	 *
	 * @return HorizontalLineBlock[]    All found horizontal line blocks which belong to the given learnplace.
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}