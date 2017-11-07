<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class Feedback
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Feedback extends ActiveRecord {

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
	protected $content = "";

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
	protected $fk_learnplace_id = NULL;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
	}


	/**
	 * @param int $pk_id
	 *
	 * @return Feedback
	 */
	public function setPkId(int $pk_id): Feedback {
		$this->pk_id = $pk_id;

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
	 * @return Feedback
	 */
	public function setContent(string $content): Feedback {
		$this->content = $content;

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
	 * @return Feedback
	 */
	public function setFkIluserId(int $fk_iluser_id): Feedback {
		$this->fk_iluser_id = $fk_iluser_id;

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
	 * @return Feedback
	 */
	public function setFkLearnplaceId($fk_learnplace_id) {
		$this->fk_learnplace_id = $fk_learnplace_id;

		return $this;
	}
}