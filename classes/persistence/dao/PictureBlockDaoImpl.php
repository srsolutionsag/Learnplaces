<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\PictureUploadBlock;

/**
 * Class PictureBlockDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureBlockDaoImpl extends AbstractCrudBlockDao implements PictureBlockDao {

	/**
	 * PictureBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(PictureUploadBlock::class);
	}
}