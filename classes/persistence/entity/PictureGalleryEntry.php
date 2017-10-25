<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class PictureGalleryEntry
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureGalleryEntry extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_picture_gallery_entry';
	}

	/**
	 * @var int
	 *
	 * @con_is_primary true
	 * @con_is_unique  true
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $pk_id;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_learnplace_id;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_picture_id;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
	}


	/**
	 * @param int $pk_id
	 *
	 * @return PictureGalleryEntry
	 */
	public function setPkId(int $pk_id): PictureGalleryEntry {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkLearnplaceId(): int {
		return $this->fk_learnplace_id;
	}


	/**
	 * @param int $fk_learnplace_id
	 *
	 * @return PictureGalleryEntry
	 */
	public function setFkLearnplaceId(int $fk_learnplace_id): PictureGalleryEntry {
		$this->fk_learnplace_id = $fk_learnplace_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkPictureId(): int {
		return $this->fk_picture_id;
	}


	/**
	 * @param int $fk_picture_id
	 *
	 * @return PictureGalleryEntry
	 */
	public function setFkPictureId(int $fk_picture_id): PictureGalleryEntry {
		$this->fk_picture_id = $fk_picture_id;

		return $this;
	}
}