<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;

/**
 * Trait BlockMappingAware
 *
 * The Block mapping aware trait provides a convenience method to map the dto blocks to the entity blocks.
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait BlockMappingAware {

	/**
	 * Maps a dto block to an entity block.
	 *
	 * @param Block             $block            The dto block which should be mapped to the entity block.
	 *
	 * @return \SRAG\Learnplaces\persistence\entity\Block   The mapped entity block.
	 */
	private function mapToBlockEntity(Block $block) : \SRAG\Learnplaces\persistence\entity\Block {
		$blockEntity = new \SRAG\Learnplaces\persistence\entity\Block($block->getId());


		$visibility = Visibility::where(['name' => $block->getVisibility()])->first();
		$blockEntity
			->setPkId($block->getId())
			->setSequence($block->getSequence())
			->setFkVisibility($visibility->getPkId());

		return $blockEntity;
	}
}