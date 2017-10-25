<?php

namespace SRAG\Lernplaces\persistence\dao;

use ActiveRecord;
use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;

/**
 * Interface LearnplaceConstraintDao
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface LearnplaceConstraintDao {

	/**
	 * Searches the learnplace constraint which belongs to the given block.
	 * The id is the block id which belongs to the block table.
	 *
	 * @param int $id The id of the block which is used to find the constraint.
	 *
	 * @return ActiveRecord The found learnplace constraint
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if the block has no learnplace constraint.
	 */
	public function findByBlockId(int $id): ActiveRecord;
}