<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\MapBlock;

/**
 * Class MapBlockDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class MapBlockDaoImpl extends AbstractCrudBlockDao implements MapBlockDao {

	/**
	 * MapBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(MapBlock::class);
	}
}