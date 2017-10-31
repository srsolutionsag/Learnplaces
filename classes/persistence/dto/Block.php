<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

/**
 * Class Block
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
abstract class Block {

	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var int $sequence
	 */
	private $sequence;
	/**
	 * @var string $visibility
	 */
	private $visibility;
	/**
	 * @var BlockConstraint[]
	 */
	private $constraints;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Block
	 */
	public function setId(int $id): Block {
		$this->id = $id;

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
	 * @return string
	 */
	public function getVisibility(): string {
		return $this->visibility;
	}


	/**
	 * @param string $visibility
	 *
	 * @return Block
	 */
	public function setVisibility(string $visibility): Block {
		$this->visibility = $visibility;

		return $this;
	}


	/**
	 * @return BlockConstraint[]
	 */
	public function getConstraints(): array {
		return $this->constraints;
	}


	/**
	 * @param BlockConstraint[] $constraints
	 *
	 * @return Block
	 */
	public function setConstraints(array $constraints): Block {
		$this->constraints = $constraints;

		return $this;
	}
}