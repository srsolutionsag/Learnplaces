<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\Block;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;

/**
 * Trait BlockDtoMappingAware
 *
 * Provides the functionality for other mapping traits to map the basic part of the block model to a block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait BlockDtoMappingAware {

	protected function fillBaseBlock(Block $block): Block {
		/**
		 * @var BlockModel|BlockDtoMappingAware $this
		 */
		$block
			->setId($this->getId())
			->setConstraint($this->getConstraint()->toDto())
			->setVisibility($this->getVisibility())
			->setSequence($this->getSequence());

		return $block;
	}

	public abstract function toDto(): Block;

}

/**
 * Trait BlockModelMappingAware
 *
 * Provides the functionality for other mapping traits to map the basic part of the block dto to a block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait BlockModelMappingAware {

	protected function fillBaseBlock(BlockModel $blockModel): BlockModel {
		/**
		 * @var Block|BlockModelMappingAware $this
		 */
		$blockModel
			->setId($this->getId())
			->setConstraint($this->getConstraint()->toModel())
			->setVisibility($this->getVisibility())
			->setSequence($this->getSequence());

		return $blockModel;
	}

	public abstract function toModel(): BlockModel;
}