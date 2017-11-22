<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\VideoBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;

/**
 * Class VideoBlockServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoBlockServiceImpl implements VideoBlockService {

	/**
	 * @var VideoBlockRepository $videoBlockRepository
	 */
	private $videoBlockRepository;


	/**
	 * VideoBlockServiceImpl constructor.
	 *
	 * @param VideoBlockRepository $videoBlockRepository
	 */
	public function __construct(VideoBlockRepository $videoBlockRepository) { $this->videoBlockRepository = $videoBlockRepository; }


	/**
	 * @inheritDoc
	 */
	public function store(VideoBlockModel $blockModel): VideoBlockModel {
		$dto = $this->videoBlockRepository->store($blockModel->toDto());
		return $dto->toModel();
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$this->videoBlockRepository->delete($id);
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The video block with the given id could not be deleted, because the block was not found.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): VideoBlockModel {
		try {
			$dto = $this->videoBlockRepository->findByBlockId($id);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The video block with the given id does not exist.', 0, $ex);
		}
	}
}