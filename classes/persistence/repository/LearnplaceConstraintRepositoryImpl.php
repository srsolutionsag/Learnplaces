<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\LearnplaceConstraint;
use SRAG\Lernplaces\persistence\dao\LearnplaceConstraintDao;

/**
 * Class LearnplaceConstraintRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceConstraintRepositoryImpl implements LearnplaceConstraintRepository {

	/**
	 * @var LearnplaceConstraintDao $learnplaceConstraintDao
	 */
	private $learnplaceConstraintDao;
	/**
	 * @var LearnplaceRepository $learnplaceRepository
	 */
	private $learnplaceRepository;


	/**
	 * LearnplaceConstraintRepositoryImpl constructor.
	 *
	 * @param LearnplaceConstraintDao $learnplaceConstraintDao
	 * @param LearnplaceRepository    $learnplaceRepository
	 */
	public function __construct(LearnplaceConstraintDao $learnplaceConstraintDao, LearnplaceRepository $learnplaceRepository) {
		$this->learnplaceConstraintDao = $learnplaceConstraintDao;
		$this->learnplaceRepository = $learnplaceRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function store(LearnplaceConstraint $constraint) : LearnplaceConstraint {
		return ($constraint->getId() > 0) ? $this->update($constraint) : $this->create($constraint);
	}

	private function create(LearnplaceConstraint $constraint) : LearnplaceConstraint {
		$activeRecord = $this->learnplaceConstraintDao->create($this->mapToEntity($constraint));
		return $this->mapToDTO($activeRecord);
	}

	private function update(LearnplaceConstraint $constraint) : LearnplaceConstraint {
		$activeRecord = $this->learnplaceConstraintDao->update($this->mapToEntity($constraint));
		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : LearnplaceConstraint {
		$learnplaceConstraintEntity = $this->learnplaceConstraintDao->findByBlockId($id);
		return $this->mapToDTO($learnplaceConstraintEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		$this->learnplaceConstraintDao->delete($id);
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\LearnplaceConstraint $constraint) : LearnplaceConstraint {

		$learnplaceConstraint = new LearnplaceConstraint();
		$learnplaceConstraint
			->setPreviousLearnplace($this->learnplaceRepository->find($constraint->getFkPreviousLearnplace()));

		return $learnplaceConstraint;

	}

	private function mapToEntity(LearnplaceConstraint $constraint) : \SRAG\Learnplaces\persistence\entity\LearnplaceConstraint {

		$learnplaceConstraintEntity = ($constraint->getId() > 0) ?
			$this->learnplaceConstraintDao->find($constraint->getId()) : new \SRAG\Learnplaces\persistence\entity\LearnplaceConstraint();

		$learnplaceConstraintEntity
			->setPkId($constraint->getId())
			->setFkPreviousLearnplace($constraint->getPreviousLearnplace()->getId());

		return $learnplaceConstraintEntity;

	}
}