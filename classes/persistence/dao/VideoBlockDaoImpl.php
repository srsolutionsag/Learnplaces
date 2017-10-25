<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\VideoBlock;

/**
 * Class VideoBlockDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoBlockDaoImpl extends AbstractCrudBlockDao implements VideoBlockDao {

	/**
	 * VideoBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(VideoBlock::class);
	}
}