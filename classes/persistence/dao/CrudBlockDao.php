<?php
/**
 * File CrudBlockDao.php
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */

namespace SRAG\Lernplaces\persistence\dao;

use ActiveRecord;
use SRAG\Learnplaces\persistence\dao\CrudDao;
use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;

/**
 * Interface CrudBlockDao
 *
 * This interface describes the contract of all block related DAO classes.
 *
 * @package SRAG\Lernplaces\persistence
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface CrudBlockDao extends CrudDao {

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
	public function findByBlockId(int $id): ActiveRecord;
}