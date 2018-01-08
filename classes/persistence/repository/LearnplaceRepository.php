<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Learnplace;

/**
 * Interface LearnplaceRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface LearnplaceRepository {

	/**
	 * Creates a new learnplace or creates a new one if the id of the learnplace was not found.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be created of updated.
	 *
	 * @return Learnplace The newly updated or created learnplace.
	 */
	public function store(Learnplace $learnplace): Learnplace;


	/**
	 * Searches a learnplace by its id.
	 *
	 * @param int $id The id which should be used to search the learnplace.
	 *
	 * @return Learnplace The found learnplace.
	 */
	public function find(int $id): Learnplace;


	/**
	 * Find the learnplace by the ILIAS object id.
	 *
	 * @param int $id   The object id which should be used to search the learnplace.
	 *
	 * @return Learnplace The learnplace with the given object id.
	 */
	public function findByObjectId(int $id): Learnplace;


	/**
	 * Deletes a learnplace by id.
	 *
	 * @param int $id The id which should be used to delete the learnplace.
	 *
	 * @return void
	 */
	public function delete(int $id);
}