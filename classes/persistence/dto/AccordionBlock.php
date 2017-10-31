<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

/**
 * Class AccordionBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AccordionBlock extends Block {

	/**
	 * @var string $title
	 */
	private $title;
	/**
	 * @var bool $expand
	 */
	private $expand;
	/**
	 * An already sorted collection of blocks.
	 * @var Block[]
	 */
	private $blocks;


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
	 * @return bool
	 */
	public function isExpand(): bool {
		return $this->expand;
	}


	/**
	 * @param bool $expand
	 *
	 * @return AccordionBlock
	 */
	public function setExpand(bool $expand): AccordionBlock {
		$this->expand = $expand;

		return $this;
	}


	/**
	 * @return Block[]
	 */
	public function getBlocks(): array {
		return $this->blocks;
	}


	/**
	 * @param Block[] $blocks
	 *
	 * @return AccordionBlock
	 */
	public function setBlocks(array $blocks): AccordionBlock {
		$this->blocks = $blocks;

		return $this;
	}
}