<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use League\Flysystem\FilesystemInterface;
use SRAG\Learnplaces\persistence\dto\VideoBlock;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\VideoBlockRepository;
use SRAG\Learnplaces\service\media\VideoService;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;
use SRAG\Learnplaces\service\publicapi\model\VideoModel;

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
	 * @var VideoService $videoService
	 */
	private $videoService;


	/**
	 * VideoBlockServiceImpl constructor.
	 *
	 * @param VideoBlockRepository $videoBlockRepository
	 * @param VideoService         $videoService
	 */
	public function __construct(VideoBlockRepository $videoBlockRepository, VideoService $videoService) {
		$this->videoBlockRepository = $videoBlockRepository;
		$this->videoService = $videoService;
	}

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
			$this->deleteVideoFiles($id);
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

	private function deleteVideoFiles(int $id) {
		$video = $this->videoBlockRepository->findByBlockId($id);
		$videoModel = new VideoModel();
		$videoModel
			->setCoverPath($video->getCoverPath())
			->setVideoPath($video->getPath());
		$this->videoService->delete($videoModel);
	}
}