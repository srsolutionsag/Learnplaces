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
	protected $user_id;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $time;
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
	 * @return int
	 */
	public function getFkLearnplaceId(): int {
		return $this->fk_learnplace_id;
	}


	/**
	 * @param int $fk_learnplace_id
	 *
	 * @return VisitJournal
	 */
	public function setFkLearnplaceId(int $fk_learnplace_id): VisitJournal {
		$this->fk_learnplace_id = $fk_learnplace_id;

		return $this;
	}
}