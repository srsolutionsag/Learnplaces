<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\security;

use Generator;
use ilAccessHandler;
use ilObject;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;
use SRAG\Learnplaces\service\visibility\LearnplaceServiceDecoratorFactory;
use function intval;
use function is_null;

/**
 * Class BlockAccessGuardImpl
 *
 * @package SRAG\Learnplaces\service\security
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class AccessGuardImpl implements AccessGuard {

	/**
	 * @var int $objectId
	 */
	private $objectId = 0;
	/**
	 * @var int $refId
	 */
	private $refId = 0;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;
	/**
	 * @var LearnplaceServiceDecoratorFactory $decorator
	 */
	private $decorator;
	/**
	 * @var ilAccessHandler $access
	 */
	private $access;
	/**
	 * @var LearnplaceModel $learnplace
	 */
	private $learnplace;


	/**
	 * AccessGuardImpl constructor.
	 *
	 * @param ServerRequestInterface            $request
	 * @param LearnplaceService                 $learnplaceService
	 * @param LearnplaceServiceDecoratorFactory $decorator
	 * @param ilAccessHandler                   $access
	 */
	public function __construct(ServerRequestInterface $request, LearnplaceService $learnplaceService, LearnplaceServiceDecoratorFactory $decorator, ilAccessHandler $access) {
		$this->decorator = $decorator;
		$this->access = $access;
		$refId = intval($request->getQueryParams()['ref_id']);
		$this->refId = $refId;
		$this->objectId = ilObject::_lookupObjectId($refId);
		$this->learnplaceService = $this->hasWritePermission() ? $learnplaceService : $decorator->decorate($learnplaceService);
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
	 * @inheritdoc
	 */
	public function hasReadPermission(): bool {
		return $this->access->checkAccess(AccessGuard::PERMISSION_READ, '', $this->refId);
	}


	/**
	 * @inheritdoc
	 */
	public function hasWritePermission(): bool {
		return $this->access->checkAccess(AccessGuard::PERMISSION_WRITE, '', $this->refId);
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