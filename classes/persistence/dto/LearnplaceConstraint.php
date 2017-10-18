<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class LearnplaceConstraint
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceConstraint implements BlockConstraint {

	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var Learnplace $previousLearnplace
	 */
	private $previousLearnplace;


	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @inheritdoc
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return Learnplace
	 */
	public function getPreviousLearnplace() {
		return $this->previousLearnplace;
	}


	/**
	 * @param Learnplace $previousLearnplace
	 *
	 * @return LearnplaceConstraint
	 */
	public function setPreviousLearnplace($previousLearnplace) {
		$this->previousLearnplace = $previousLearnplace;

		return $this;
	}
}