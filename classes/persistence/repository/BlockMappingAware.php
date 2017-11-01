<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dao\CrudDao;
use SRAG\Learnplaces\persistence\dao\VisibilityDao;
use SRAG\Learnplaces\persistence\dto\Block;

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
	 * @param VisibilityDao     $visibilityDao    The visibility dao used to fetch the visibility relation.
	 *
	 * @return \SRAG\Learnplaces\persistence\entity\Block   The mapped entity block.
	 */
	private function mapToBlockEntity(Block $block, VisibilityDao $visibilityDao) : \SRAG\Learnplaces\persistence\entity\Block {
		$blockEntity = ($block->getId() > 0) ?
			$this->$visibilityDao->find($block->getId()) : new \SRAG\Learnplaces\persistence\entity\Block();
		$blockEntity
			->setPkId($block->getId())
			->setSequence($block->getSequence())
			->setFkVisibility($this->$visibilityDao->findByName($block->getVisibility())->getPkId());
	}
}