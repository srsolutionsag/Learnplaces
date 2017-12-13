<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\MapBlock;

use ilCtrl;
use ilLearnplacesPlugin;
use ilLinkButton;
use ilMapUtil;
use ilTemplate;
use ilToolbarGUI;
use LogicException;
use SRAG\Learnplaces\gui\block\util\ReadOnlyViewAware;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\model\LocationModel;
use SRAG\Learnplaces\service\publicapi\model\MapBlockModel;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;
use xsrlMapBlockGUI;

/**
 * Class MapBlockPresentationView
 *
 * @package SRAG\Learnplaces\gui\block\MapBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class MapBlockPresentationView {

	use ReadOnlyViewAware;

	const MAP_ZOOM = 10;

	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var ilTemplate $template
	 */
	private $template;
	/**
	 * @var ilCtrl $controlFlow
	 */
	private $controlFlow;
	/**
	 * @var PictureBlockModel $model
	 */
	private $model;
	/**
	 * @var LocationModel $location
	 */
	private $location;


	/**
	 * PictureUploadBlockPresentationView constructor.
	 *
	 * @param ilLearnplacesPlugin $plugin
	 * @param ilCtrl              $controlFlow
	 */
	public function __construct(ilLearnplacesPlugin $plugin, ilCtrl $controlFlow) {
		$this->plugin = $plugin;
		$this->controlFlow = $controlFlow;
		$this->template = new ilTemplate('./Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces/templates/default/tpl.map_tab.html', true, true);
	}

	private function initView() {

		//setup button
		$deleteAction = ilLinkButton::getInstance();
		$deleteAction->setCaption($this->plugin->txt('common_delete'), false);
		$deleteAction->setUrl($this->controlFlow->getLinkTargetByClass(xsrlMapBlockGUI::class, CommonControllerAction::CMD_CONFIRM) . '&' . xsrlMapBlockGUI::BLOCK_ID_QUERY_KEY . '=' . $this->model->getId());

		$editAction = ilLinkButton::getInstance();
		$editAction->setCaption($this->plugin->txt('common_edit'), false);
		$editAction->setUrl($this->controlFlow->getLinkTargetByClass(xsrlMapBlockGUI::class, CommonControllerAction::CMD_EDIT) . '&' . xsrlMapBlockGUI::BLOCK_ID_QUERY_KEY . '=' . $this->model->getId());

		$toolbar = new ilToolbarGUI();
		$toolbar->addButtonInstance($editAction);
		$toolbar->addButtonInstance($deleteAction);

		$map = ilMapUtil::getMapGUI();
		$map->setMapId($map_id = "map_" . hash('sha256', uniqid('map', true)))
				->setLatitude($this->location->getLatitude())
				->setLongitude($this->location->getLongitude())
				->setZoom(self::MAP_ZOOM)
				->setEnableTypeControl(true)
				->setEnableLargeMapControl(true)
				->setEnableUpdateListener(false)
				->setEnableCentralMarker(true)
				->setWidth('100%')
				->setHeight('500px');

		if(!$this->isReadonly()) {
			$this->template->setVariable('TOOLBAR', $toolbar->getHTML());
		}
		$this->template->setVariable('CONTENT', $map->getHtml());
	}

	public function setModels(MapBlockModel $model, LocationModel $location) {
		$this->model = $model;
		$this->location = $location;
		$this->initView();
	}


	/**
	 * @inheritDoc
	 */
	public function getHtml() {
		if(is_null($this->model))
			throw new LogicException('The picture block view requires a model to render its content.');

		return $this->template->get();
	}

}