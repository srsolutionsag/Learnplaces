<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\PictureUploadBlock;

use ilCtrl;
use ilLearnplacesPlugin;
use ilLinkButton;
use ilSplitButtonException;
use ilSplitButtonGUI;
use ilTemplate;
use ilTextInputGUI;
use function is_null;
use LogicException;
use SRAG\Learnplaces\gui\block\Renderable;
use SRAG\Learnplaces\gui\block\util\ReadOnlyViewAware;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\model\PictureUploadBlockModel;
use xsrlPictureUploadBlockGUI;

/**
 * Class PictureUploadBlockPresentationView
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PictureUploadBlockPresentationView implements Renderable {

	use ReadOnlyViewAware;

	const SEQUENCE_ID_PREFIX = 'picture_upload_';

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
	 * @var PictureUploadBlockModel $model
	 */
	private $model;


	/**
	 * PictureUploadBlockPresentationView constructor.
	 *
	 * @param ilLearnplacesPlugin $plugin
	 * @param ilCtrl              $controlFlow
	 */
	public function __construct(ilLearnplacesPlugin $plugin, ilCtrl $controlFlow) {
		$this->plugin = $plugin;
		$this->controlFlow = $controlFlow;
		$this->template = new ilTemplate('./Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces/templates/default/block/tpl.picture_upload.html', true, true);
		$this->initView();
	}


	private function initView() {
		$this->template->setVariable('CONTENT', $this->plugin->txt('picture_upload_block_content'));
	}

	public function setModel(PictureUploadBlockModel $model) {
		$this->model = $model;
	}


	/**
	 * @inheritDoc
	 */
	public function getHtml() {
		if(is_null($this->model))
			throw new LogicException('The picture upload block view requires a model to render its content.');

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
		$deleteAction->setUrl($this->controlFlow->getLinkTargetByClass(xsrlPictureUploadBlockGUI::class, CommonControllerAction::CMD_CONFIRM) . '&' . xsrlPictureUploadBlockGUI::BLOCK_ID_QUERY_KEY . '=' . $this->model->getId());
		$splitButton->setDefaultButton($deleteAction);

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