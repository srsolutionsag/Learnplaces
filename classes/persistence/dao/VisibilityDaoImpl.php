<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

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
}