<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class Block
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Block extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_block';
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
	protected $sequence;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_visibility;
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
	 * @return Block
	 */
	public function setPkId(int $pk_id): Block {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getSequence(): int {
		return $this->sequence;
	}


	/**
	 * @param int $sequence
	 *
	 * @return Block
	 */
	public function setSequence(int $sequence): Block {
		$this->sequence = $sequence;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkVisibility(): int {
		return $this->fk_visibility;
	}


	/**
	 * @param int $fk_visibility
	 *
	 * @return Block
	 */
	public function setFkVisibility(int $fk_visibility): Block {
		$this->fk_visibility = $fk_visibility;

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
	 * @return Block
	 */
	public function setFkLearnplaceId(int $fk_learnplace_id): Block {
		$this->fk_learnplace_id = $fk_learnplace_id;

		return $this;
	}
}