<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class Answer
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Answer extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_answer';
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
	protected $fk_comment_id = NULL;
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
	 * @return Answer
	 */
	public function setPkId(int $pk_id): Answer {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getCreateDate(): int {
		return $this->create_date;
	}


	/**
	 * @param int $create_date
	 *
	 * @return Answer
	 */
	public function setCreateDate(int $create_date): Answer {
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
	 * @return Answer
	 */
	public function setTitle(string $title): Answer {
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
	 * @return Answer
	 */
	public function setContent(string $content): Answer {
		$this->content = $content;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkCommentId() {
		return $this->fk_comment_id;
	}


	/**
	 * @param int|null $fk_comment_id
	 *
	 * @return Answer
	 */
	public function setFkCommentId($fk_comment_id) {
		$this->fk_comment_id = $fk_comment_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkIluserId(): int {
		return $this->fk_iluser_id;
	}


	/**
	 * @param int $fk_iluser_id
	 *
	 * @return Answer
	 */
	public function setFkIluserId(int $fk_iluser_id): Answer {
		$this->fk_iluser_id = $fk_iluser_id;

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
	 * @return Answer
	 */
	public function setFkPictureId($fk_picture_id) {
		$this->fk_picture_id = $fk_picture_id;

		return $this;
	}
}