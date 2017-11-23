<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\AccordionBlockRepository;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;

/**
 * Class AccordionBlockServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AccordionBlockServiceImpl implements AccordionBlockService {

	/**
	 * @var AccordionBlockRepository $accordionBlockRepository
	 */
	private $accordionBlockRepository;


	/**
	 * AccordionBlockServiceImpl constructor.
	 *
	 * @param AccordionBlockRepository $accordionBlockRepository
	 */
	public function __construct(AccordionBlockRepository $accordionBlockRepository) { $this->accordionBlockRepository = $accordionBlockRepository; }


	/**
	 * @inheritDoc
	 */
	public function store(AccordionBlockModel $blockModel): AccordionBlockModel {
		$dto = $this->accordionBlockRepository->store($blockModel->toDto());
		return $dto->toModel();
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$this->accordionBlockRepository->delete($id);
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The accordion block with the given id could not be deleted, because the block was not found.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): AccordionBlockModel {
		try {
			$dto = $this->accordionBlockRepository->findByBlockId($id);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The accordion block with the given id does not exist.', 0, $ex);
		}
	}
}