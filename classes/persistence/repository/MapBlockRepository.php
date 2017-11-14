<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\MapBlock;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface MapBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface MapBlockRepository {

	/**
	 * Updates a map block or creates a new one id the block id was not found.
	 *
	 * @param MapBlock $mapBlock    The map block which should be updated or created.
	 *
	 * @return MapBlock             The updated or created map block.
	 */
	public function store(MapBlock $mapBlock): MapBlock;


	/**
	 * Searches a map block by block id.
	 *
	 * @param int $id   The id of the block which should be used to search the map block.
	 *
	 * @return MapBlock The found map block with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the map block with the given id was not found.
	 */
	public function findByBlockId(int $id): MapBlock;


	/**
	 * Removes the map block with the given id.
	 *
	 * @param int $id   The id which should be used to remove the map block.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the map block with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches all map blocks which belong to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search all corresponding map blocks.
	 *
	 * @return MapBlock[]   All found map blocks which belong to the learnplace.
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}