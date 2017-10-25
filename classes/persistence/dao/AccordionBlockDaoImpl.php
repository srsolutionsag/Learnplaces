<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\AccordionBlock;
use SRAG\Lernplaces\persistence\dao\AbstractCrudBlockDao;

/**
 * Class AccordionBlockImpl
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AccordionBlockDaoImpl extends AbstractCrudBlockDao implements AccordionBlockDao {

	/**
	 * AccordionBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(AccordionBlock::class);
	}
}