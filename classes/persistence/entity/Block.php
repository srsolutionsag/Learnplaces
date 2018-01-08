<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;
use function intval;

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
	protected $sequence = 0;
	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_visibility = NULL;
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
		return intval($this->pk_id);
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
		return intval($this->sequence);
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
	 * @return int|null
	 */
	public function getFkVisibility() {
		return is_null($this->fk_visibility) ? NULL : intval($this->fk_visibility);
	}


	/**
	 * @param int|null $fk_visibility
	 *
	 * @return Block
	 */
	public function setFkVisibility($fk_visibility) {
		$this->fk_visibility = $fk_visibility;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkLearnplaceId() {
		return is_null($this->fk_learnplace_id) ? NULL : intval($this->fk_learnplace_id);
	}


	/**
	 * @param int|null $fk_learnplace_id
	 *
	 * @return Block
	 */
	public function setFkLearnplaceId($fk_learnplace_id) {
		$this->fk_learnplace_id = $fk_learnplace_id;

		return $this;
	}
}