<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;
use function intval;

/**
 * Class AccordionBlockMember
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AccordionBlockMember extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_accordion_block_m'; //xsrl_accordion_block_member
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
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_block_id = NULL;

	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_accordion_block = NULL;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return intval($this->pk_id);
	}


	/**
	 * @param int $pk_id
	 *
	 * @return AccordionBlockMember
	 */
	public function setPkId(int $pk_id): AccordionBlockMember {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkBlockId() {
		return is_null($this->fk_block_id) ? NULL : intval($this->fk_block_id);
	}


	/**
	 * @param int|null $fk_block_id
	 *
	 * @return AccordionBlockMember
	 */
	public function setFkBlockId($fk_block_id) {
		$this->fk_block_id = $fk_block_id;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getFkAccordionBlock() {
		return is_null($this->fk_accordion_block) ? NULL : intval($this->fk_accordion_block);
	}


	/**
	 * @param int|null $fk_accordion_block
	 *
	 * @return AccordionBlockMember
	 */
	public function setFkAccordionBlock($fk_accordion_block) {
		$this->fk_accordion_block = $fk_accordion_block;

		return $this;
	}
}