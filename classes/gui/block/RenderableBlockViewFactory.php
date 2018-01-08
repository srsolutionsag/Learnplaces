<?php

namespace SRAG\Learnplaces\gui\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;

/**
 * Interface RenderableBlockViewFactory
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface RenderableBlockViewFactory {

	/**
	 * Generates a renderable view for the given block model.
	 *
	 * @param BlockModel $blockModel    Which should be wrapped by a renderable view.
	 *
	 * @return Renderable   A renderable view for the given model.
	 * @throws InvalidArgumentException
	 *                      Thrown if the block model has no corresponding view.
	 */
	public function getInstance(BlockModel $blockModel): Renderable;
}