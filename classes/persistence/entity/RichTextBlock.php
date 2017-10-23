<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class RichTextBlock
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class RichTextBlock extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_rich_text_block';
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
	 * @con_fieldtype  clob
	 */
	protected $content;
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
	 * @return RichTextBlock
	 */
	public function setPkId(int $pk_id): RichTextBlock {
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
	 * @return RichTextBlock
	 */
	public function setContent(string $content): RichTextBlock {
		$this->content = $content;

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
	 * @return RichTextBlock
	 */
	public function setFkBlockId(int $fk_block_id): RichTextBlock {
		$this->fk_block_id = $fk_block_id;

		return $this;
	}
}