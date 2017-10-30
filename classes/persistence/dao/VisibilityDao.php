<?php

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\entity\Visibility;

/**
 * Interface VisibilityDao
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface VisibilityDao extends CrudDao {

	/**
	 * Searches a visibility by its name. The first visibility with the provided name will be returned.
	 *
	 * @param string $name The name of the visibility.
	 *
	 * @return Visibility The visibility with the given name.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if no visibility with the given name was found.
	 */
	public function findByName(string $name) : Visibility;

}