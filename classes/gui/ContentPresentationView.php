<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui;

use ilCtrl;
use ilLearnplacesPlugin;
use InvalidArgumentException;
use SRAG\Learnplaces\gui\block\RenderableBlockViewFactory;
use SRAG\Learnplaces\gui\block\util\ReadOnlyViewAware;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use xsrlContentGUI;

/**
 * Class ContentPresentationView
 *
 * @package SRAG\Learnplaces\gui
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class ContentPresentationView {

	use ReadOnlyViewAware;

	/**
	 * @var ilCtrl $controlFlow
	 */
	private $controlFlow;
	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var RenderableBlockViewFactory $renderableFactory
	 */
	private $renderableFactory;
	/**
	 * @var BlockModel[] $blocks
	 */
	private $blocks;
	/**
	 * @var int $accordionId
	 */
	private $accordionId = 0;


	/**
	 * ContentPresentationView constructor.
	 *
	 * @param ilCtrl                     $controlFlow
	 * @param ilLearnplacesPlugin        $plugin
	 * @param RenderableBlockViewFactory $renderableFactory
	 */
	public function __construct(ilCtrl $controlFlow, ilLearnplacesPlugin $plugin, RenderableBlockViewFactory $renderableFactory) {
		$this->controlFlow = $controlFlow;
		$this->plugin = $plugin;
		$this->renderableFactory = $renderableFactory;
	}


	/**
	 * @param BlockModel[] $blocks
	 */
	public function setBlocks(array $blocks) {
		$this->blocks = $blocks;
	}


	public function setAccordionId(int $id) {
		$this->accordionId = $id;
	}

	public function getHTML():string {
		return $this->renderView();
	}

	private function renderView(): string {

		$writePermission = !$this->isReadonly();

		$blockHtml = ($writePermission) ? $this->getPlusView(0)->getHTML() : '';
		foreach ($this->blocks as $position => $block) {
			try {
				$view = $this->renderableFactory->getInstance($block);
				$view->setReadonly(!$writePermission);
				$blockHtml .= $view->getHtml();

				if($writePermission)
					$blockHtml .= $this->getPlusView(intval($position) + 1)->getHTML();
			}
			catch (InvalidArgumentException $exception) {
				//ignore the models without view
			}
		}

		return $blockHtml;
	}

	private function getPlusView(int $position): PlusView {
		return new PlusView($position, $this->controlFlow->getLinkTargetByClass(xsrlContentGUI::class, CommonControllerAction::CMD_ADD), $this->accordionId);
	}

}