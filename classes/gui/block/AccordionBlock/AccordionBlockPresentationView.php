<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\AccordionBlock;

use ilButtonToSplitButtonMenuItemAdapter;
use ilCtrl;
use ilLearnplacesPlugin;
use ilLinkButton;
use ilSplitButtonException;
use ilSplitButtonGUI;
use ilTemplate;
use ilTextInputGUI;
use LogicException;
use SRAG\Learnplaces\container\PluginContainer;
use SRAG\Learnplaces\gui\block\Renderable;
use SRAG\Learnplaces\gui\block\util\ReadOnlyViewAware;
use SRAG\Learnplaces\gui\ContentPresentationView;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use xsrlAccordionBlockGUI;

/**
 * Class AccordionBlockPresentationView
 *
 * @package SRAG\Learnplaces\gui\block\AccordionBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class AccordionBlockPresentationView implements Renderable {

	use ReadOnlyViewAware;

	const SEQUENCE_ID_PREFIX = 'picture_';

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
	 * @var AccordionBlockModel $model
	 */
	private $model;
	/**
	 * @var ContentPresentationView $contentView
	 */
	private $contentView;


	/**
	 * PictureUploadBlockPresentationView constructor.
	 *
	 * @param ilLearnplacesPlugin     $plugin
	 * @param ilCtrl                  $controlFlow
	 * @param ContentPresentationView $contentView
	 */
	public function __construct(ilLearnplacesPlugin $plugin, ilCtrl $controlFlow, ContentPresentationView $contentView) {
		$this->plugin = $plugin;
		$this->controlFlow = $controlFlow;
		$this->contentView = $contentView;
		$this->template = new ilTemplate('./Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces/templates/default/block/tpl.accordion.html', true, true);
	}

	private function initView() {
		$this->contentView->setBlocks($this->model->getBlocks());
		$this->contentView->setAccordionId($this->model->getId());
		$this->contentView->setReadonly($this->isReadonly());

		$this->template->setVariable('ACCORDION_ID', $this->model->getId());
		$this->template->setVariable('TITLE', $this->model->getTitle());
		$this->template->setVariable('CONTENT', $this->contentView->getHTML());
		$this->template->setVariable('EXPANDED', $this->model->isExpand() ? 'true' : 'false');
	}

	public function setModel(AccordionBlockModel $model) {
		$this->model = $model;
	}

	/**
	 * @inheritDoc
	 */
	public function getHtml() {
		if(is_null($this->model))
			throw new LogicException('The accordion block view requires a model to render its content.');

		$this->initView();
		return $this->wrapWithBlockTemplate($this->template)->get();
	}

	/**
	 * Wraps the given template with the tpl.block.html template.
	 *
	 * @param ilTemplate $template      The block template which should be wrapped.
	 *
	 * @return ilTemplate               The wrapped template.
	 *
	 * @throws ilSplitButtonException   Thrown if something went wrong with the split button.
	 */
	private function wrapWithBlockTemplate(ilTemplate $template): ilTemplate {
		$outerTemplate = new ilTemplate('./Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces/templates/default/tpl.block.html', true, true);

		//setup button
		$splitButton = ilSplitButtonGUI::getInstance();
		$deleteAction = ilLinkButton::getInstance();
		$deleteAction->setCaption($this->plugin->txt('common_delete'), false);
		$deleteAction->setUrl($this->controlFlow->getLinkTargetByClass(xsrlAccordionBlockGUI::class, CommonControllerAction::CMD_CONFIRM) . '&' . xsrlAccordionBlockGUI::BLOCK_ID_QUERY_KEY . '=' . $this->model->getId());

		$editAction = ilLinkButton::getInstance();
		$editAction->setCaption($this->plugin->txt('common_edit'), false);
		$editAction->setUrl($this->controlFlow->getLinkTargetByClass(xsrlAccordionBlockGUI::class, CommonControllerAction::CMD_EDIT) . '&' . xsrlAccordionBlockGUI::BLOCK_ID_QUERY_KEY . '=' . $this->model->getId());
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
		$outerTemplate->setVariable('CONTENT', $template->get());
		return $outerTemplate;
	}

}