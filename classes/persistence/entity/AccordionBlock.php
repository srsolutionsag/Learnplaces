<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class AccordionBlock
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AccordionBlock extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_accordion_block';
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
	 * @var string
	 *
	 * @con_is_notnull true
	 * @con_has_field  true
	 * @con_fieldtype  text
	 * @con_length     256
	 */
	protected $title;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     1
	 */
	protected $expand;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_unique  true
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
	 * @return AccordionBlock
	 */
	public function setPkId(int $pk_id): AccordionBlock {
		$this->pk_id = $pk_id;

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
	 * @return AccordionBlock
	 */
	public function setTitle(string $title): AccordionBlock {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getExpand(): int {
		return $this->expand;
	}


	/**
	 * @param int $expand
	 *
	 * @return AccordionBlock
	 */
	public function setExpand(int $expand): AccordionBlock {
		$this->expand = $expand;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkUpperBlock(): int {
		return $this->fk_upper_block;
	}


	/**
	 * @param int $fk_upper_block
	 *
	 * @return AccordionBlock
	 */
	public function setFkUpperBlock(int $fk_upper_block): AccordionBlock {
		$this->fk_upper_block = $fk_upper_block;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkLowerBlock(): int {
		return $this->fk_lower_block;
	}


	/**
	 * @param int $fk_lower_block
	 *
	 * @return AccordionBlock
	 */
	public function setFkLowerBlock(int $fk_lower_block): AccordionBlock {
		$this->fk_lower_block = $fk_lower_block;

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
	 * @return AccordionBlock
	 */
	public function setFkBlockId(int $fk_block_id): AccordionBlock {
		$this->fk_block_id = $fk_block_id;

		return $this;
	}
}