<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\PictureUploadBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\PictureUploadBlockModel;

/**
 * Class PictureUploadBlockServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PictureUploadBlockServiceImpl implements PictureUploadBlockService {

	/**
	 * @var PictureUploadBlockRepository $pictureUploadBlockRepository
	 */
	private $pictureUploadBlockRepository;


	/**
	 * PictureBlockServiceImpl constructor.
	 *
	 * @param PictureUploadBlockRepository $pictureBlockRepository
	 */
	public function __construct(PictureUploadBlockRepository $pictureBlockRepository) { $this->pictureUploadBlockRepository = $pictureBlockRepository; }


	/**
	 * @inheritDoc
	 */
	public function store(PictureUploadBlockModel $blockModel): PictureUploadBlockModel {
		$dto = $this->pictureUploadBlockRepository->store($blockModel->toDto());
		return $dto->toModel();
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$this->pictureUploadBlockRepository->delete($id);
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The picture upload block with the given id could not be deleted, because the block was not found.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): PictureUploadBlockModel {
		try {
			$dto = $this->pictureUploadBlockRepository->findByBlockId($id);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The picture upload block with the given id does not exist.', 0, $ex);
		}
	}
}