<?php

namespace SRAG\Lernplaces\persistence\dto;

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
	public function getTitle() {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return AccordionBlock
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return bool
	 */
	public function isExpand() {
		return $this->expand;
	}


	/**
	 * @param bool $expand
	 *
	 * @return AccordionBlock
	 */
	public function setExpand($expand) {
		$this->expand = $expand;

		return $this;
	}


	/**
	 * @return Block[]
	 */
	public function getBlocks() {
		return $this->blocks;
	}


	/**
	 * @param Block[] $blocks
	 *
	 * @return AccordionBlock
	 */
	public function setBlocks($blocks) {
		$this->blocks = $blocks;

		return $this;
	}

}