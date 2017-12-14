<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\util;

use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\gui\component\PlusView;

/**
 * Trait AccordionIdAware
 *
 * @package SRAG\Learnplaces\gui\block\util
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait AccordionAware {

	/**
	 * Fetch the requested accordion which should contain the new block.
	 * If the id is 0, the block should be put in the learnplace it self.
	 *
	 * @param ServerRequestInterface $request   The request which should be used to search after the query parameter.
	 *
	 * @return int  The positive accordion block id.
	 *
	 * @see PlusView::ACCORDION_QUERY_PARAM  The query param which is searched by this method.
	 */
	private function getCurrentAccordionId(ServerRequestInterface $request): int {
		$accordionId = 0;
		if(!array_key_exists(PlusView::ACCORDION_QUERY_PARAM, $request->getQueryParams()))
			return $accordionId;

		$accordionId = intval($request->getQueryParams()[PlusView::ACCORDION_QUERY_PARAM]);
		$accordionId = $accordionId >= 0 ? $accordionId : 0;
		return $accordionId;
	}
}