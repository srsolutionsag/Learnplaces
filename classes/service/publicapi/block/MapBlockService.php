<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\MapBlockModel;

/**
 * Interface MapBlockService
 *
 * This interface defines the public available operations which must be
 * used to manipulate the map block.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface MapBlockService {

	/**
	 * Updates a map block model or creates a new if the block with the given id was not found.
	 *
	 * @param MapBlockModel $blockModel The block which should be updated or created.
	 *
	 * @return MapBlockModel            The newly updated or created block.
	 */
	public function store(MapBlockModel $blockModel): MapBlockModel;


	/**
	 * Deletes a map block with the given id.
	 *
	 * @param int $id   The id of the map block which should be deleted.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *                  Thrown if the block id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches the map block with the given id.
	 *
	 * @param int $id           The id of the map block which should be found.
	 *
	 * @return MapBlockModel    The map block with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                          Thrown if the block with the given id was not found.
	 */
	public function find(int $id): MapBlockModel;


	/**
	 * Searches after a map within the learnplace which belongs to the given object id.
	 *
	 * @param int $objectId     The object id of the learnpalce which should be used to search for the map block.
	 *
	 * @return MapBlockModel    The map block model which belongs to the given learnplace.
	 *
	 * @throws InvalidArgumentException
	 *                          Thrown if no map was found for the learnplace with the given object id.
	 */
	public function findByObjectId(int $objectId): MapBlockModel;

}