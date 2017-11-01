<?php

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\Block;

/**
 * Interface BlockDao
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface BlockDao extends CrudDao {

	/**
	 * Finds all blocks which belong to the learnplace with the given id.
	 *
	 * @param int $id   The learnplace id which should be used to find all blocks.
	 *
	 * @return Block[]  All blocks which belong to the learnplace.
	 */
	public function findByLearnplaceId(int $id) : array;
}