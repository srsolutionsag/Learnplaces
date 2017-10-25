<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class LearnplaceConstraint
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceConstraint extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_learnplace_constraint';
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
	protected $fk_previous_learnplace;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_block_id;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
	}


	/**
	 * @param int $pk_id
	 *
	 * @return LearnplaceConstraint
	 */
	public function setPkId(int $pk_id): LearnplaceConstraint {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkPreviousLearnplace(): int {
		return $this->fk_previous_learnplace;
	}


	/**
	 * @param int $fk_previous_learnplace
	 *
	 * @return LearnplaceConstraint
	 */
	public function setFkPreviousLearnplace(int $fk_previous_learnplace): LearnplaceConstraint {
		$this->fk_previous_learnplace = $fk_previous_learnplace;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkBlockId(): int {
		return $this->fk_block_id;
	}


	/**
	 * @param int $fk_block_id
	 *
	 * @return LearnplaceConstraint
	 */
	public function setFkBlockId(int $fk_block_id): LearnplaceConstraint {
		$this->fk_block_id = $fk_block_id;

		return $this;
	}
}