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
	 * @inheritdoc
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