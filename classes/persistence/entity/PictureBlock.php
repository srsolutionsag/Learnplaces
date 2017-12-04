<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class PictureBlock
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureBlock extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_picture_block';
	}

	/**
	 * @var int
	 *
	 * @con_is_primary true
	 * @con_sequence   true
	 * @con_is_unique  true
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $pk_id = 0;
	/**
	 * @var string
	 *
	 * @con_is_notnull true
	 * @con_has_field  true
	 * @con_fieldtype  text
	 * @con_length     256
	 */
	protected $title = "";
	/**
	 * @var string
	 *
	 * @con_is_notnull true
	 * @con_has_field  true
	 * @con_fieldtype  text
	 * @con_length     2000
	 */
	protected $description = "";
	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_picture = NULL;
	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_unique  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_block_id = NULL;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
	}


	/**
	 * @param int $pk_id
	 *
	 * @return PictureBlock
	 */
	public function setPkId(int $pk_id): PictureBlock {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return PictureBlock
	 */
	public function setTitle(string $title): PictureBlock {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->description;
	}


	/**
	 * @param string $description
	 *
	 * @return PictureBlock
	 */
	public function setDescription(string $description): PictureBlock {
		$this->description = $description;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkPicture() {
		return $this->fk_picture;
	}


	/**
	 * @param int|null $fk_picture
	 *
	 * @return PictureBlock
	 */
	public function setFkPicture($fk_picture) {
		$this->fk_picture = $fk_picture;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkBlockId() {
		return $this->fk_block_id;
	}


	/**
	 * @param int|null $fk_block_id
	 *
	 * @return PictureBlock
	 */
	public function setFkBlockId($fk_block_id) {
		$this->fk_block_id = $fk_block_id;

		return $this;
	}
}