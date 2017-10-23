<?php

namespace SRAG\Learnplaces\aop\aspect;

use Go\Core\AspectContainer;
use Go\Core\AspectKernel;

/**
 * Class AspectKernel
 *
 * @package SRAG\Learnplaces\aop\aspect
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceAspectKernel extends AspectKernel {

	/**
	 * @inheritDoc
	 */
	protected function configureAop(AspectContainer $container) {

		//register all aspects
	}
}