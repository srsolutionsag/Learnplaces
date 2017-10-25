<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\PictureUploadBlock;

/**
 * Class PictureUploadBlockDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureUploadBlockDaoImpl extends AbstractCrudBlockDao implements PictureUploadBlockDao {

	/**
	 * PictureUploadBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(PictureUploadBlock::class);
	}
}