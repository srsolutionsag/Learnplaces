<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\util;

use function array_key_exists;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\gui\component\PlusView;

/**
 * Trait InsertPositionAware
 *
 * @package SRAG\Learnplaces\gui\block\util
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait InsertPositionAware {

	/**
	 * Fetch the requested insert position of the new block.
	 *
	 * @param ServerRequestInterface $request   The request which should be used to search after the query parameter.
	 *
	 * @return int  The zero based insert index.
	 *
	 * @see PlusView::POSITION_QUERY_PARAM  The query param which is searched by this method.
	 */
	private function getInsertPosition(ServerRequestInterface $request): int {
		$position = 0;
		if(!array_key_exists(PlusView::POSITION_QUERY_PARAM, $request->getQueryParams()))
			return $position;

		$position = intval($request->getQueryParams()[PlusView::POSITION_QUERY_PARAM]);
		$position = $position >= 0 ? $position : 0;
		return $position;
	}
}