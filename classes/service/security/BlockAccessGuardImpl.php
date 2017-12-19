<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\security;

use ilObject;
use function intval;
use function is_null;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;

/**
 * Class BlockAccessGuardImpl
 *
 * @package SRAG\Learnplaces\service\security
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class BlockAccessGuardImpl implements BlockAccessGuard {

	/**
	 * @var int $objectId
	 */
	private $objectId = 0;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;
	/**
	 * @var LearnplaceModel $learnplace
	 */
	private $learnplace;


	/**
	 * BlockAccessGuardImpl constructor.
	 *
	 * @param ServerRequestInterface $request
	 * @param LearnplaceService      $learnplaceService
	 */
	public function __construct(ServerRequestInterface $request, LearnplaceService $learnplaceService) {
		$this->learnplaceService = $learnplaceService;
		$refId = intval($request->getQueryParams()['ref_id']);
		$this->objectId = ilObject::_lookupObjectId($refId);
	}


	/**
	 * @inheritdoc
	 */
	public function isValidBlockReference(int $blockId): bool {
		foreach ($this->getLearnplace()->getBlocks() as $block) {
			if($block->getId() === $blockId)
				return true;
		}

		return false;
	}

	private function getLearnplace() {
		if(is_null($this->learnplace)) {
			$this->learnplace = $this->learnplaceService->findByObjectId($this->objectId);
		}
		return $this->learnplace;
	}
}