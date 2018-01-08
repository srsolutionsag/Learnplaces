<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;
use function intval;

/**
 * Class Comment
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Comment extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_comment';
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
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $create_date = 0;
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
	protected $content = "";
	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_comment_block = NULL;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_iluser_id = 0;
	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_picture_id = NULL;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return intval($this->pk_id);
	}


	/**
	 * @param int $pk_id
	 *
	 * @return Comment
	 */
	public function setPkId(int $pk_id): Comment {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getCreateDate(): int {
		return intval($this->create_date);
	}


	/**
	 * @param int $create_date
	 *
	 * @return Comment
	 */
	public function setCreateDate(int $create_date): Comment {
		$this->create_date = $create_date;

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
	 * @return Comment
	 */
	public function setTitle(string $title): Comment {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getContent(): string {
		return $this->content;
	}


	/**
	 * @param string $content
	 *
	 * @return Comment
	 */
	public function setContent(string $content): Comment {
		$this->content = $content;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkCommentBlock() {
		return is_null($this->fk_comment_block) ? NULL : intval($this->fk_comment_block);
	}


	/**
	 * @param int|null $fk_comment_block
	 *
	 * @return Comment
	 */
	public function setFkCommentBlock($fk_comment_block) {
		$this->fk_comment_block = $fk_comment_block;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkIluserId(): int {
		return intval($this->fk_iluser_id);
	}


	/**
	 * @param int $fk_iluser_id
	 *
	 * @return Comment
	 */
	public function setFkIluserId(int $fk_iluser_id): Comment {
		$this->fk_iluser_id = $fk_iluser_id;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkPictureId() {
		return is_null($this->fk_picture_id) ? NULL : intval($this->fk_picture_id);
	}


	/**
	 * @param int|null $fk_picture_id
	 *
	 * @return Comment
	 */
	public function setFkPictureId($fk_picture_id) {
		$this->fk_picture_id = $fk_picture_id;

		return $this;
	}
}