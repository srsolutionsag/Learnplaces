<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class VideoBlock
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoBlock extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_video_block';
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
	 * @var string
	 *
	 * @con_is_notnull true
	 * @con_has_field  true
	 * @con_fieldtype  text
	 * @con_length     2000
	 */
	protected $path = "";
	/**
	 * @var string
	 *
	 * @con_is_notnull true
	 * @con_has_field  true
	 * @con_fieldtype  text
	 * @con_length     2000
	 */
	protected $cover_path = "";
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
	 * @return VideoBlock
	 */
	public function setPkId(int $pk_id): VideoBlock {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getPath(): string {
		return $this->path;
	}


	/**
	 * @param string $path
	 *
	 * @return VideoBlock
	 */
	public function setPath(string $path): VideoBlock {
		$this->path = $path;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getCoverPath(): string {
		return $this->cover_path;
	}


	/**
	 * @param string $cover_path
	 *
	 * @return VideoBlock
	 */
	public function setCoverPath(string $cover_path): VideoBlock {
		$this->cover_path = $cover_path;

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
	 * @return VideoBlock
	 */
	public function setFkBlockId($fk_block_id) {
		$this->fk_block_id = $fk_block_id;

		return $this;
	}
}