<?php

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\Learnplace;

/**
 * Interface LearnplaceDao
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface LearnplaceDao extends CrudDao {

	/**
	 * Searches a learnplace by id.
	 *
	 * @param int $id The id which should be used to search the learnplace.
	 *
	 * @return Learnplace The found learnplace.
	 */
	public function findByObjectId(int $id) : Learnplace;

}