<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;
use function is_null;

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
	 * @con_sequence   true
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
	 * @con_length     256
	 */
	protected $title = "";
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     1
	 */
	protected $expand = 0;
	/**
	 * @var int|null
	 *
	 * @con_has_field  true
	 * @con_is_unique  true
	 * @con_is_notnull false
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_block_id = NULL;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return intval($this->pk_id);
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
		return intval($this->expand);
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
	 * @return int|null
	 */
	public function getFkBlockId() {
		return is_null($this->fk_block_id) ? NULL : intval($this->fk_block_id);
	}


	/**
	 * @param int|null $fk_block_id
	 *
	 * @return AccordionBlock
	 */
	public function setFkBlockId($fk_block_id) {
		$this->fk_block_id = $fk_block_id;

		return $this;
	}
}