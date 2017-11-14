<?php

namespace SRAG\Learnplaces\persistence\repository;

use ilDatabaseException;
use SRAG\Learnplaces\persistence\dto\Picture;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface PictureRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface PictureRepository {

	/**
	 * Updates a picture or creates a new one if the picture id was not found.
	 *
	 * @param Picture $picture  The picture which should be updated or created.
	 *
	 * @return Picture          The updated or created picture.
	 */
	public function store(Picture $picture): Picture;


	/**
	 * Searches a picture by id.
	 *
	 * @param int $id   The id which should be used to find the picture.
	 *
	 * @return Picture  The picture with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the picture with the given id was not found.
	 */
	public function find(int $id): Picture;


	/**
	 * Deletes a picture by id.
	 *
	 * @param int $id   The id of the picture which should be deleted.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the picture with the given id was not found.
	 * @throws ilDatabaseException
	 *                  Thrown if a database error occurred while deleting the picture.
	 */
	public function delete(int $id);
}