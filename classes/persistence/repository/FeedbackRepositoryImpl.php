<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function array_map;
use ilDatabaseException;
use SRAG\Learnplaces\persistence\dto\Feedback;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class FeedbackRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class FeedbackRepositoryImpl implements FeedbackRepository {

	/**
	 * @inheritdoc
	 */
	public function store(Feedback $feedback) : Feedback {
		$activeRecord = $this->mapToEntity($feedback);
		$activeRecord->store();
		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function find(int $id) : Feedback {
		try {
			$feedbackEntity = \SRAG\Learnplaces\persistence\entity\Feedback::findOrFail($id);
			return $this->mapToDTO($feedbackEntity);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Feedback with id \"$id\" not found.", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplaceId(int $id) : array {
		/**
		 * @var \SRAG\Learnplaces\persistence\entity\Feedback[] $feedbackEntities
		 */
		$feedbackEntities = \SRAG\Learnplaces\persistence\entity\Feedback::where(['fk_learnplace_id' => $id])->get();

		return array_map(
			function(\SRAG\Learnplaces\persistence\entity\Feedback $feedbackEntity) {return $this->mapToDTO($feedbackEntity);},
			$feedbackEntities
		);
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$feedbackEntity = \SRAG\Learnplaces\persistence\entity\Feedback::findOrFail($id);
			$feedbackEntity->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Feedback with id \"$id\" not found.", $ex);
		}
		catch(ilDatabaseException $ex) {
			throw new ilDatabaseException("Unable to delete feedback with id \"$id\"");
		}
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\Feedback $feedbackEntity) : Feedback {

		$feedback = new Feedback();
		$feedback
			->setId($feedbackEntity->getPkId())
			->setContent($feedbackEntity->getContent())
			->setUserId($feedbackEntity->getFkIluserId());

		return $feedback;
	}

	private function mapToEntity(Feedback $feedback) : \SRAG\Learnplaces\persistence\entity\Feedback {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\Feedback $activeRecord
		 */
		$activeRecord = new \SRAG\Learnplaces\persistence\entity\Feedback($feedback->getId());

		$activeRecord
			->setPkId($feedback->getId())
			->setContent($feedback->getContent())
			->setFkIluserId($feedback->getUserId());

		return $activeRecord;
	}

}