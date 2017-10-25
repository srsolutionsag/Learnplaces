<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\Configuration;

/**
 * Class Configuration
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ConfigurationDaoImpl extends AbstractCrudDao implements ConfigurationDao {

	/**
	 * ConfigurationDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(Configuration::class);
	}
}