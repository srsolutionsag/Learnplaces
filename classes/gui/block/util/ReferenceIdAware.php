<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\util;

use ilAccessHandler;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\service\security\AccessGuard;
use function strcmp;

/**
 * Trait ReferenceIdAware
 *
 * @package SRAG\Learnplaces\gui\block\util
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait ReferenceIdAware {

	/**
	 * @var ServerRequestInterface $request
	 */
	private $request;

	private function getCurrentRefId(): int {
		$queries = $this->request->getQueryParams();
		return intval($queries["ref_id"]);
	}
}