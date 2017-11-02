<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

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
		return 'xsrl_accordion_block_member';
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
	protected $fk_block_id;

	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_accordion_block;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
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
	 * @return int
	 */
	public function getFkBlockId(): int {
		return $this->fk_block_id;
	}


	/**
	 * @param int $fk_block_id
	 *
	 * @return AccordionBlockMember
	 */
	public function setFkBlockId(int $fk_block_id): AccordionBlockMember {
		$this->fk_block_id = $fk_block_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkAccordionBlock(): int {
		return $this->fk_accordion_block;
	}


	/**
	 * @param int $fk_accordion_block
	 *
	 * @return AccordionBlockMember
	 */
	public function setFkAccordionBlock(int $fk_accordion_block): AccordionBlockMember {
		$this->fk_accordion_block = $fk_accordion_block;

		return $this;
	}
}