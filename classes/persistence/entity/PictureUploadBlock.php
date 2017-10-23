<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class PictureUploadBlock
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureUploadBlock extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_picture_upload_block';
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
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
	}


	/**
	 * @param int $pk_id
	 *
	 * @return PictureUploadBlock
	 */
	public function setPkId(int $pk_id): PictureUploadBlock {
		$this->pk_id = $pk_id;

		return $this;
	}
}