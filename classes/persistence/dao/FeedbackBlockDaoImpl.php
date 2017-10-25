<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\FeedbackBlock;

/**
 * Class FeedbackBlock
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class FeedbackBlockDaoImpl extends AbstractCrudBlockDao implements FeedbackBlockDao {

	/**
	 * FeedbackBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(FeedbackBlock::class);
	}
}