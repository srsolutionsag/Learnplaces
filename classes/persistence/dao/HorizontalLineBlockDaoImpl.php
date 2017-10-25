<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\HorizontalLineBlock;

/**
 * Class HorizontalLineBlock
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class HorizontalLineBlockDaoImpl extends AbstractCrudBlockDao implements HorizontalLineBlockDao {

	/**
	 * HorizontalLineBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(HorizontalLineBlock::class);
	}
}