<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\Location;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface LocationRepository
 *
 * @package SRAG\Lernplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface LocationRepository {

	/**
	 * Creates a new location if the location id is not set or updates an existent location.
	 *
	 * @param Location $location The location which should be stored.
	 *
	 * @return Location The newly created or updated location.
	 */
	public function store(Location $location): Location;


	/**
	 * Searches a location by id.
	 *
	 * @param int $id   The id of the location which should be found.
	 *
	 * @return Location The location with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the location with the given id was not found.
	 */
	public function find(int $id): Location;


	/**
	 * Deletes an entity with the given id.
	 *
	 * @param int $id       The id of the location which should be deleted.
	 *
	 * @return void
	 * @throws EntityNotFoundException
	 *                      Thrown if the location with the given id was not found.
	 */
	public function delete(int $id);

	/**
	 * Searches the learnplace which belongs to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search after the corresponding location.
	 *
	 * @return Location                 The location of the learnplace.
	 * @throws EntityNotFoundException  Thrown if the location of the learnplace was not found.
	 */
	public function findByLearnplace(Learnplace $learnplace) : Location;
}