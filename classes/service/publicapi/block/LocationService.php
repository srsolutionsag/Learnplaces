<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\LocationModel;

/**
 * Interface LocationService
 *
 * This interface defines the public available operations which must be
 * used to manipulate the location of the learnplace.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface LocationService {

	/**
	 * Updates an existing location or creates a new one if the location id was not found.
	 *
	 * @param LocationModel $locationModel  The location which should be updated or created.
	 *
	 * @return LocationModel                The newly created or updated location.
	 */
	public function store(LocationModel $locationModel): LocationModel;


	/**
	 * Deletes the location with the given id.
	 *
	 * @param int $id   The id of the location which should be removed.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *                  Thrown if the location with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches a location with the given id.
	 *
	 * @param int $id           The id of the location which should be found.
	 *
	 * @return LocationModel    The location with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                          Thrown if the location with the given id was not found.
	 */
	public function find(int $id): LocationModel;

}