<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class Block
 *
 * @package StuderRaimannCh\Lernplaces\persistence\dto
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
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Block
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getSequence() {
		return $this->sequence;
	}


	/**
	 * @param int $sequence
	 *
	 * @return Block
	 */
	public function setSequence($sequence) {
		$this->sequence = $sequence;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getVisibility() {
		return $this->visibility;
	}


	/**
	 * @param string $visibility
	 *
	 * @return Block
	 */
	public function setVisibility($visibility) {
		$this->visibility = $visibility;

		return $this;
	}


	/**
	 * @return BlockConstraint[]
	 */
	public function getConstraints() {
		return $this->constraints;
	}


	/**
	 * @param BlockConstraint[] $constraints
	 *
	 * @return Block
	 */
	public function setConstraints($constraints) {
		$this->constraints = $constraints;

		return $this;
	}
}