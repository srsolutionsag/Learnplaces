<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\AccordionBlock;
use SRAG\Learnplaces\persistence\dto\Block;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;

/**
 * Trait AccordionBlockDtoMappingAware
 *
 * Defines the mapping of the accordion block model to the accordion block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 */
trait AccordionBlockDtoMappingAware {

	public function toDto(): AccordionBlock {
		/**
		 * @var AccordionBlockModel|AccordionBlockDtoMappingAware $this
		 */

		$blockDtos = array_map(
			function(BlockModel $blockModel) {$blockModel->toDto();},
			$this->getBlocks()
		);

		$dto = new AccordionBlock();
		$dto
			->setTitle($this->getTitle())
			->setExpand($this->isExpand())
			->setBlocks($blockDtos);
		$this->fillBaseBlock($dto);

		return $dto;
	}

}

/**
 * Trait AccordionBlockModelMappingAware
 *
 * Defines the mapping of the accordion block dto to the accordion block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait AccordionBlockModelMappingAware {

	public function toDto(): AccordionBlockModel {
		/**
		 * @var AccordionBlock|AccordionBlockModelMappingAware $this
		 */

		$blockModels = array_map(
			function(Block $block) {$block->toModel();},
			$this->getBlocks()
		);

		$model = new AccordionBlockModel();
		$model
			->setTitle($this->getTitle())
			->setExpand($this->isExpand())
			->setBlocks($blockModels);
		$this->fillBaseBlock($model);

		return $model;
	}
}