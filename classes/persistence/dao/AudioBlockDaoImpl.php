<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\AudioBlock;

/**
 * Class AudioBlockDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AudioBlockDaoImpl extends AbstractCrudBlockDao implements AudioBlockDao {

	/**
	 * AudioBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(AudioBlock::class);
	}
}