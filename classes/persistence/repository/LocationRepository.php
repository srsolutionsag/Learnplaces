<?php

namespace SRAG\Lernplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Location;

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
	 * @param int $id The of the location
	 *
	 * @return Location
	 */
	public function find(int $id): Location;


	/**
	 * Deletes an entity with the given id.
	 *
	 * @param int $id
	 *
	 * @return void
	 */
	public function delete(int $id);
}