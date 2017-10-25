<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\ILIASLinkBlock;

/**
 * Class ILIASLinkBlockDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ILIASLinkBlockDaoImpl extends AbstractCrudBlockDao implements ILIASLinkBlockDao {

	/**
	 * ILIASLinkBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(ILIASLinkBlock::class);
	}
}