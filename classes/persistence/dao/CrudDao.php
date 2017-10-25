<?php

namespace SRAG\Learnplaces\persistence\dao;

use ActiveRecord;
use ActiveRecordList;
use ilDatabaseException;
use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;

/**
 * Interface CrudDao
 *
 * The abstract crud dao provides the CRUD functionality for all DAOs.
 *
 * @package SRAG\Learnplaces\persistence
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface CrudDao {

	/**
	 * Searches an entity by id.
	 *
	 * @param int $id The id which should be used to search the entity.
	 *
	 * @return ActiveRecord
	 * @throws EntityNotFoundException
	 *                          Thrown if the active record was unable
	 *                          to locate the data with the given id.
	 */
	public function find(int $id): ActiveRecord;


	/**
	 * Creates a new entry for the given active record.
	 *
	 * @param ActiveRecord $activeRecord The active record which should be ceated.
	 *
	 * @return ActiveRecord The created active record.
	 *
	 * @throws ilDatabaseException
	 *                      Thrown if the creation of the record fails.
	 */
	public function create(ActiveRecord $activeRecord): ActiveRecord;


	/**
	 * Updates an already existing active record.
	 *
	 * @param ActiveRecord $activeRecord The active record which should be updated.
	 *
	 * @return ActiveRecord The updated active record.
	 *
	 * @throws ilDatabaseException
	 *                      Thrown if the update of the active record fails.
	 */
	public function update(ActiveRecord $activeRecord): ActiveRecord;


	/**
	 * @param int $id The id of the entity which should be deleted.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if the given entity id was not found.
	 * @throws ilDatabaseException
	 *                          Thrown if the entity could not be deleted.
	 */
	public function delete(int $id);
}