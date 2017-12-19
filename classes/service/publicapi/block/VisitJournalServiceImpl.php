<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\dto\VisitJournal;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\VisitJournalRepository;
use SRAG\Learnplaces\service\publicapi\model\VisitJournalModel;

/**
 * Class VisitJournalServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class VisitJournalServiceImpl implements VisitJournalService {

	/**
	 * @var VisitJournalRepository $visitJournalRepository
	 */
	private $visitJournalRepository;


	/**
	 * VisitJournalServiceImpl constructor.
	 *
	 * @param VisitJournalRepository $visitJournalRepository
	 */
	public function __construct(VisitJournalRepository $visitJournalRepository) { $this->visitJournalRepository = $visitJournalRepository; }


	/**
	 * @inheritDoc
	 */
	public function store(VisitJournalModel $visitJournalModel): VisitJournalModel {
		$dto = $this->visitJournalRepository->store($visitJournalModel->toDto());
		return $dto->toModel();
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$this->visitJournalRepository->delete($id);
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The visit journal with the given id could not be deleted, because it was not found.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): VisitJournalModel {
		try {
			$dto = $this->visitJournalRepository->find($id);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The visit journal with the given id does not exist.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function findByObjectId(int $id): array {
		$dtos = $this->visitJournalRepository->findByObjectId($id);
		$models = array_map(
			function(VisitJournal $journal): VisitJournalModel {return $journal->toModel();},
			$dtos
		);

		return $models;
	}
}