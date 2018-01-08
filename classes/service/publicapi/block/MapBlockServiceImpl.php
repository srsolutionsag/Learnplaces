<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\MapBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\MapBlockModel;

/**
 * Class MapBlockServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class MapBlockServiceImpl implements MapBlockService {

	/**
	 * @var MapBlockRepository $mapBlockRepository
	 */
	private $mapBlockRepository;


	/**
	 * MapBlockServiceImpl constructor.
	 *
	 * @param MapBlockRepository $mapBlockRepository
	 */
	public function __construct(MapBlockRepository $mapBlockRepository) { $this->mapBlockRepository = $mapBlockRepository; }


	/**
	 * @inheritDoc
	 */
	public function store(MapBlockModel $blockModel): MapBlockModel {
		$dto = $this->mapBlockRepository->store($blockModel->toDto());
		return $dto->toModel();
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$this->mapBlockRepository->delete($id);
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The map block with the given id could not be deleted, because the block was not found.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): MapBlockModel {
		try {
			$dto = $this->mapBlockRepository->findByBlockId($id);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The map block with the given id does not exist.', 0, $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByObjectId(int $objectId): MapBlockModel {
		try {
			$dto = $this->mapBlockRepository->findByObjectId($objectId);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('No map block belongs to the learnpalce with the given object id.', 0, $ex);
		}
	}
}