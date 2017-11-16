<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\AccordionBlockDtoMappingAware;

/**
 * Class AccordionBlockModelModel
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AccordionBlockModel extends BlockModel {

	use AccordionBlockDtoMappingAware;

	/**
	 * @var string $title
	 */
	private $title = "";
	/**
	 * @var bool $expand
	 */
	private $expand = false;
	/**
	 * An already sorted collection of blocks.
	 *
	 * @var BlockModel[]
	 */
	private $blocks = [];


	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return AccordionBlockModel
	 */
	public function setTitle(string $title): AccordionBlockModel {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return bool
	 */
	public function isExpand(): bool {
		return $this->expand;
	}


	/**
	 * @param bool $expand
	 *
	 * @return AccordionBlockModel
	 */
	public function setExpand(bool $expand): AccordionBlockModel {
		$this->expand = $expand;

		return $this;
	}


	/**
	 * @return BlockModel[]
	 */
	public function getBlocks(): array {
		return $this->blocks;
	}


	/**
	 * @param BlockModel[] $blocks
	 *
	 * @return AccordionBlockModel
	 */
	public function setBlocks(array $blocks): AccordionBlockModel {
		$this->blocks = $blocks;

		return $this;
	}
}