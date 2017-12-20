<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\security;

use Generator;
use ilObject;
use function intval;
use function is_null;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
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
		$blocks = $this->getLearnplace()->getBlocks();
		foreach ($this->walkBlockTree($blocks) as $block) {
			if($block->getId() === $blockId)
				return true;
		}

		return false;
	}


	/**
	 * @param BlockModel[] $blocks
	 *
	 * @return Generator
	 */
	private function walkBlockTree(array $blocks): Generator {
		foreach ($blocks as $block) {
			yield $block;
			if($block instanceof AccordionBlockModel)
				yield from $this->walkBlockTree($block->getBlocks());
		}
	}

	private function getLearnplace() {
		if(is_null($this->learnplace)) {
			$this->learnplace = $this->learnplaceService->findByObjectId($this->objectId);
		}
		return $this->learnplace;
	}
}