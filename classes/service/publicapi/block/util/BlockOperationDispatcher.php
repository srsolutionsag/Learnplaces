<?php

namespace SRAG\Learnplaces\service\publicapi\block\util;

use SRAG\Learnplaces\service\publicapi\model\BlockModel;

/**
 * Interface BlockOperationDispatcher
 *
 * Dispatch operations to the correct service by block type.
 *
 * @package SRAG\Learnplaces\service\publicapi\block\util
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface BlockOperationDispatcher {

	/**
	 * Deletes all block models.
	 *
	 * @param BlockModel[] $blocks  The blocks which should be deleted.
	 *
	 * @return void
	 */
	public function deleteAll(array $blocks);


	/**
	 * Stores all given blocks.
	 *
	 * @param BlockModel[] $blocks The array of blocks which should be stored.
	 *
	 * @return BlockModel[]
	 */
	public function storeAll(array $blocks): array;
}