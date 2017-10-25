<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use ActiveRecord;
use arException;
use ilDatabaseException;
use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;

/**
 * Class AbstractCrudDao
 *
 * The abstract crud dao provides the CRUD functionality for all DAOs.
 *
 * @package SRAG\Learnplaces\persistence
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
abstract class AbstractCrudDao implements CrudDao {

	/**
	 * @var string $activeRecordClass
	 */
	private $activeRecordClass;


	/**
	 * AbstractCrudDao constructor.
	 *
	 * @param string $activeRecordClass
	 *
	 */
	public function __construct(string $activeRecordClass) {
		$this->$activeRecordClass = new $activeRecordClass();
	}


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
	public final function find(int $id): ActiveRecord {

		try
		{
			return new $this->activeRecordClass($id);
		}
		catch (arException $exception) {
			throw new EntityNotFoundException("Entity with id \"$id\" was not found.");
		}
	}


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
	public final function create(ActiveRecord $activeRecord) : ActiveRecord{
		$activeRecord->create();
		return $activeRecord;
	}


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
	public final function update(ActiveRecord $activeRecord) : ActiveRecord{
		$activeRecord->update();
		return $activeRecord;
	}


	/**
	 * @param int $id The id of the entity which should be deleted.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if the given entity id was not found.
	 * @throws ilDatabaseException
	 *                          Thrown if the entity could not be deleted.
	 */
	public final function delete(int $id) {
		$activeRecord = $this->find($id);
		$activeRecord->delete();
	}


	/**
	 * @return string
	 */
	protected final function getActiveRecordClass() : string {
		return $this->activeRecordClass;
	}
}