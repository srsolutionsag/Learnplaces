<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use function is_null;
use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\entity\Visibility;

/**
 * Class VisibilityDaoImpl
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VisibilityDaoImpl extends AbstractCrudDao implements VisibilityDao {

	/**
	 * VisibilityDoaImpl constructor.
	 */
	public function __construct() {
		parent::__construct(Visibility::class);
	}


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
	public function findByName(string $name) : Visibility {
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::where(['name' => $name])->first();
		if(is_null($visibility))
			throw new EntityNotFoundException("Visibility with the name \"$visibility\" not found.");

		return $visibility;
	}
}