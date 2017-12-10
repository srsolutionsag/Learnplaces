<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block;

use function get_class;
use InvalidArgumentException;
use SRAG\Learnplaces\container\PluginContainer;
use SRAG\Learnplaces\gui\block\PictureBlock\PictureBlockPresentationView;
use SRAG\Learnplaces\gui\block\PictureUploadBlock\PictureUploadBlockPresentationView;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;
use SRAG\Learnplaces\service\publicapi\model\PictureUploadBlockModel;

/**
 * Class RenderableBlockViewFactoryImpl
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class RenderableBlockViewFactoryImpl implements RenderableBlockViewFactory {

	/**
	 * Generates a renderable view for the given block model.
	 *
	 * @param BlockModel $blockModel    Which should be wrapped by a renderable view.
	 *
	 * @return Renderable   A renderable view for the given model.
	 * @throws InvalidArgumentException
	 *                      Thrown if the block model has no corresponding view.
	 */
	public function getInstance(BlockModel $blockModel): Renderable {
		$modelClass = get_class($blockModel);
		switch ($modelClass) {
			case PictureUploadBlockModel::class:
				return $this->getPictureUploadPresentationView($blockModel);
			case PictureBlockModel::class:
				return $this->getPicturePresentationView($blockModel);
			default:
				throw new InvalidArgumentException('Model has no corresponding view.');
		}
	}

	private function getPictureUploadPresentationView(PictureUploadBlockModel $model): PictureUploadBlockPresentationView {
		/**
		 * @var PictureUploadBlockPresentationView $view
		 */
		$view = PluginContainer::resolve(PictureUploadBlockPresentationView::class);
		$view->setModel($model);
		return $view;
	}

	private function getPicturePresentationView(PictureBlockModel $model): PictureBlockPresentationView {
		/**
		 * @var PictureBlockPresentationView $view
		 */
		$view = PluginContainer::resolve(PictureBlockPresentationView::class);
		$view->setModel($model);
		return $view;
	}
}