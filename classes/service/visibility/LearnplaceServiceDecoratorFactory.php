<?php

namespace SRAG\Learnplaces\service\visibility;

use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;

/**
 * Interface LearnplaceDecoratorFactory
 *
 * @package SRAG\Learnplaces\service\visibility
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface LearnplaceServiceDecoratorFactory {

	/**
	 * Decorate the service with the visibility filter decorators.
	 * Make sure to NEVER save something about the decorated services, this could lead to
	 * unexpected behaviours.
	 *
	 * @param LearnplaceService $learnplaceService
	 *
	 * @return LearnplaceService
	 */
	public function decorate(LearnplaceService $learnplaceService): LearnplaceService;
}