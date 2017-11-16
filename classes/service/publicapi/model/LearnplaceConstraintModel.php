<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\LearnplaceConstraintDtoMappingAware;

/**
 * Class LearnplaceConstraint
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceConstraintModel implements BlockConstraint {

	use LearnplaceConstraintDtoMappingAware;

	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var LearnplaceModel $previousLearnplace
	 */
	private $previousLearnplace;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return BlockConstraint
	 */
	public function setId(int $id): BlockConstraint {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return LearnplaceModel
	 */
	public function getPreviousLearnplace(): LearnplaceModel {
		return $this->previousLearnplace;
	}


	/**
	 * @param LearnplaceModel $previousLearnplace
	 *
	 * @return LearnplaceConstraintModel
	 */
	public function setPreviousLearnplace(LearnplaceModel $previousLearnplace): LearnplaceConstraintModel {
		$this->previousLearnplace = $previousLearnplace;

		return $this;
	}

}