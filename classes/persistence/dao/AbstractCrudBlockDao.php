<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use ActiveRecord;
use ActiveRecordList;
use SRAG\Learnplaces\persistence\dao\AbstractCrudDao;
use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;

/**
 * Class AbstractCrudBlockDao
 *
 * An abstract CRUD implementation for all entities which represent a block.
 * This class adds additional query methods which are required for all block DAO classes.
 * Therefore only block classes must extend this class.
 *
 * @package SRAG\Lernplaces\persistence
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
abstract class AbstractCrudBlockDao extends AbstractCrudDao implements CrudBlockDao {

	private $whereFunctionRef;

	/**
	 * AbstractCrudBlockDao constructor.
	 *
	 * @param string $activeRecordClass The active record which should be used for the database operations.
	 */
	public function __construct(string $activeRecordClass) {
		parent::__construct($activeRecordClass);
		$this->whereFunctionRef = "$activeRecordClass::where"; //possible since PHP 7
	}


	/**
	 * Searches the block type with the given id.
	 * The id is the block id which belongs to the block table.
	 *
	 * @param int $id The block id which should be used to find the specific block type.
	 *
	 * @return ActiveRecord The specific block entity.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if no block entity was found of the given type.
	 */
	public final function findByBlockId(int $id): ActiveRecord {
		$method = $this->whereFunctionRef;

		/**
		 * @var ActiveRecordList $recordList
		 */
		$recordList = $method(['fk_block_id' => $id]);
		$result = $recordList->first();

		if(is_null($result))
			throw new EntityNotFoundException("Specific block with block id \"$id\" was not found.");

		return $result;

	}
}