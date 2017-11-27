<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\ILIASLinkBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\ILIASLinkBlockModel;

/**
 * Class ILIASLinkBlockServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ILIASLinkBlockServiceImpl implements ILIASLinkBlockService {

	/**
	 * @var ILIASLinkBlockRepository $iliasLinkBlockRepository
	 */
	private $iliasLinkBlockRepository;


	/**
	 * ILIASLinkBlockServiceImpl constructor.
	 *
	 * @param ILIASLinkBlockRepository $iliasLinkBlockRepository
	 */
	public function __construct(ILIASLinkBlockRepository $iliasLinkBlockRepository) { $this->iliasLinkBlockRepository = $iliasLinkBlockRepository; }

	/**
	 * @inheritDoc
	 */
	public function store(ILIASLinkBlockModel $blockModel): ILIASLinkBlockModel {
		$dto = $this->iliasLinkBlockRepository->store($blockModel->toDto());
		return $dto->toModel();
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$this->iliasLinkBlockRepository->delete($id);
		}
		catch(EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The ILIAS link block with the given id could not be deleted, because the block was not found.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): ILIASLinkBlockModel {
		try {
			$dto = $this->iliasLinkBlockRepository->findByBlockId($id);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The ILIAS link block with the given id does not exist.', 0, $ex);
		}
	}
}