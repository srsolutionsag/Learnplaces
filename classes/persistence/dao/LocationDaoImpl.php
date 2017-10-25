<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\Location;

/**
 * Class LocationDaoImpl
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LocationDaoImpl extends AbstractCrudDao implements LocationDao {

	/**
	 * LocationDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(Location::class);
	}
}