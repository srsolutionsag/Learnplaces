<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\VideoBlock;

use ilButtonToSplitButtonMenuItemAdapter;
use ilCtrl;
use ilLearnplacesPlugin;
use ilLinkButton;
use ilSplitButtonException;
use ilSplitButtonGUI;
use ilTemplate;
use ilTextInputGUI;
use LogicException;
use SRAG\Learnplaces\gui\block\Renderable;
use SRAG\Learnplaces\gui\block\util\ReadOnlyViewAware;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;
use xsrlVideoBlockGUI;

/**
 * Class VideoBlockPresentationView
 *
 * @package SRAG\Learnplaces\gui\block\VideoBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class VideoBlockPresentationView implements Renderable {

	use ReadOnlyViewAware;

	const SEQUENCE_ID_PREFIX = 'block_';

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
	 * @var VideoBlockModel $model
	 */
	private $model;


	/**
	 * Video constructor.
	 *
	 * @param ilLearnplacesPlugin $plugin
	 * @param ilCtrl              $controlFlow
	 */
	public function __construct(ilLearnplacesPlugin $plugin, ilCtrl $controlFlow) {
		$this->plugin = $plugin;
		$this->controlFlow = $controlFlow;
		$this->template = new ilTemplate('./Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces/templates/default/block/tpl.video.html', true, true);
	}


	private function initView() {
		$this->template->setVariable('VIDEO_PATH', $this->model->getPath());
	}

	public function setModel(VideoBlockModel $model) {
		$this->model = $model;
	}


	/**
	 * @inheritDoc
	 */
	public function getHtml() {
		if(is_null($this->model))
			throw new LogicException('The video block view requires a model to render its content.');

		$this->initView();
		return $this->wrapWithBlockTemplate($this->template)->get();
	}


	/**
	 * Wraps the given template with the tpl.block.html template.
	 *
	 * @param ilTemplate $blockTemplate The block template which should be wrapped.
	 * @return ilTemplate               The wrapped template.
	 *
	 * @throws ilSplitButtonException   Thrown if something went wrong with the split button.
	 */
	private function wrapWithBlockTemplate(ilTemplate $blockTemplate): ilTemplate {
		$outerTemplate = new ilTemplate('./Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces/templates/default/tpl.block.html', true, true);

		//setup button
		$splitButton = ilSplitButtonGUI::getInstance();
		$deleteAction = ilLinkButton::getInstance();
		$deleteAction->setCaption($this->plugin->txt('common_delete'), false);
		$deleteAction->setUrl($this->controlFlow->getLinkTargetByClass(xsrlVideoBlockGUI::class, CommonControllerAction::CMD_CONFIRM) . '&' . xsrlVideoBlockGUI::BLOCK_ID_QUERY_KEY . '=' . $this->model->getId());
		$splitButton->setDefaultButton($deleteAction);

		$editAction = ilLinkButton::getInstance();
		$editAction->setCaption($this->plugin->txt('common_edit'), false);
		$editAction->setUrl($this->controlFlow->getLinkTargetByClass(xsrlVideoBlockGUI::class, CommonControllerAction::CMD_EDIT) . '&' . xsrlVideoBlockGUI::BLOCK_ID_QUERY_KEY . '=' . $this->model->getId());
		$splitButton->setDefaultButton($editAction);
		$splitButton->addMenuItem(new ilButtonToSplitButtonMenuItemAdapter($deleteAction));

		//setup sequence number
		$input = new ilTextInputGUI('', self::SEQUENCE_ID_PREFIX . $this->model->getId());
		$input->setRequired(true);
		$input->setValidationRegexp('/^\d+$/');
		$input->setValue($this->model->getSequence());
		$input->setRequired(true);

		//fill outer template
		if(!$this->isReadonly()) {
			$outerTemplate->setVariable('ACTION_BUTTON', $splitButton->render());
			$outerTemplate->setVariable('SEQUENCE_INPUT', $input->render());
		}
		$outerTemplate->setVariable('CONTENT', $blockTemplate->get());
		return $outerTemplate;
	}
}