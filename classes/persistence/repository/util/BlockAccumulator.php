<?php

namespace SRAG\Learnplaces\persistence\repository\util;

use SRAG\Learnplaces\persistence\dto\Block;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface BlockAccumulator
 *
 * The block accumulator searches specific blocks by block ids or leanplace id.
 * For example a specific blocks are AudioBlock, VideoBlock ...
 * The block id is from the block data table and belongs to exact one specific block.
 *
 * @package SRAG\Learnplaces\persistence\repository\util
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface BlockAccumulator {

	/**
	 * Searches the specific block which belongs to the given id.
	 *
	 * @param int $id   The id of the block which should be used to fetch the specific block.
	 *
	 * @return Block    The found specific block with the given block id.
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if no block with the given id exists.
	 */
	public function fetchSpecificBlocksById(int $id): Block;
}