<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class VisitJournal
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VisitJournal extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_visit_journal';
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
	protected $user_id = 0;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $time = 0;
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
	 * @return VisitJournal
	 */
	public function setPkId(int $pk_id): VisitJournal {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getUserId(): int {
		return $this->user_id;
	}


	/**
	 * @param int $user_id
	 *
	 * @return VisitJournal
	 */
	public function setUserId(int $user_id): VisitJournal {
		$this->user_id = $user_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getTime(): int {
		return $this->time;
	}


	/**
	 * @param int $time
	 *
	 * @return VisitJournal
	 */
	public function setTime(int $time): VisitJournal {
		$this->time = $time;

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
	 * @return VisitJournal
	 */
	public function setFkLearnplaceId($fk_learnplace_id) {
		$this->fk_learnplace_id = $fk_learnplace_id;

		return $this;
	}
}