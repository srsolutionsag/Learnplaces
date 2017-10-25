<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\Block;

/**
 * Class BlockDaoImpl
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class BlockDaoImpl extends AbstractCrudDao implements BlockDao {

	/**
	 * BlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(Block::class);
	}
}