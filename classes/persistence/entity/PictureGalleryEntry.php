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
	protected $pk_id = 0;
	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_learnplace_id = NULL;
	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_picture_id = NULL;


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
	 * @return int|null
	 */
	public function getFkLearnplaceId() {
		return $this->fk_learnplace_id;
	}


	/**
	 * @param int|null $fk_learnplace_id
	 *
	 * @return PictureGalleryEntry
	 */
	public function setFkLearnplaceId($fk_learnplace_id) {
		$this->fk_learnplace_id = $fk_learnplace_id;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkPictureId() {
		return $this->fk_picture_id;
	}


	/**
	 * @param int|null $fk_picture_id
	 *
	 * @return PictureGalleryEntry
	 */
	public function setFkPictureId($fk_picture_id) {
		$this->fk_picture_id = $fk_picture_id;

		return $this;
	}
}