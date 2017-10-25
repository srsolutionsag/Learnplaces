<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\ExternalStreamBlock;

/**
 * Class ExternalStreamBlockDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ExternalStreamBlockDaoImpl extends AbstractCrudBlockDao implements ExternalStreamBlockDao {

	/**
	 * ExternalStreamBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(ExternalStreamBlock::class);
	}
}