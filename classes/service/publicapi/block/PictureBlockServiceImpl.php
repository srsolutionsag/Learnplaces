<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\PictureBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;

/**
 * Class PictureBlockServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureBlockServiceImpl implements PictureBlockService {

	/**
	 * @var PictureBlockRepository $pictureBlockRepository
	 */
	private $pictureBlockRepository;


	/**
	 * PictureBlockServiceImpl constructor.
	 *
	 * @param PictureBlockRepository $pictureBlockRepository
	 */
	public function __construct(PictureBlockRepository $pictureBlockRepository) { $this->pictureBlockRepository = $pictureBlockRepository; }


	/**
	 * @inheritDoc
	 */
	public function store(PictureBlockModel $blockModel): PictureBlockModel {
		$dto = $this->pictureBlockRepository->store($blockModel->toDto());
		return $dto->toModel();
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$this->pictureBlockRepository->delete($id);
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The picture block with the given id could not be deleted, because the block was not found.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): PictureBlockModel {
		try {
			$dto = $this->pictureBlockRepository->findByBlockId($id);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The picture block with the given id does not exist.', 0, $ex);
		}
	}
}