<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\AbstractCrudDao;
use SRAG\Learnplaces\persistence\entity\Picture;

/**
 * Class PictureDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureDaoImpl extends AbstractCrudDao implements PictureDao {

	/**
	 * PictureDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(Picture::class);
	}
}