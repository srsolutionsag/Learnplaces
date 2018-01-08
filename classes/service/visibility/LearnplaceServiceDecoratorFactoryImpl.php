<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\visibility;

use ilObjUser;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;

/**
 * Class LearnplaceServiceDecoratorFactory
 *
 * @package SRAG\Learnplaces\service\visibility
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class LearnplaceServiceDecoratorFactoryImpl implements LearnplaceServiceDecoratorFactory {

	/**
	 * @var ilObjUser $user
	 */
	private $user;


	/**
	 * LearnplaceServiceDecoratorFactoryImpl constructor.
	 *
	 * @param ilObjUser $user
	 */
	public function __construct(ilObjUser $user) { $this->user = $user; }


	/**
	 * @inheritDoc
	 */
	public function decorate(LearnplaceService $learnplaceService): LearnplaceService {
		return new NeverVisibleDecorator(new AfterVisitPlaceVisibleDecorator($this->user, $learnplaceService));
	}
}