<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use Exception;
use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\ExternalStreamBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\ExternalStreamBlockModel;

/**
 * Class External
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 * @deprecated Not needed for current version
 */
final class ExternalStreamBlockServiceImpl implements ExternalStreamBlockService {

	/**
	 * @var ExternalStreamBlockRepository $externalStreamBlockRepository
	 */
	private $externalStreamBlockRepository;


	/**
	 * ExternalStreamBlockServiceImpl constructor.
	 *
	 * @param ExternalStreamBlockRepository $externalStreamBlockRepository
	 */
	public function __construct(ExternalStreamBlockRepository $externalStreamBlockRepository) { $this->externalStreamBlockRepository = $externalStreamBlockRepository; }


	/**
	 * @inheritDoc
	 */
	public function store(ExternalStreamBlockModel $blockModel): ExternalStreamBlockModel {
		throw new Exception('Not implemented yet.');
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		throw new Exception('Not implemented yet.');
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): ExternalStreamBlockModel {
		throw new Exception('Not implemented yet.');
	}
}