<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block;

use ilCtrl;
use ilFormSectionHeaderGUI;
use ilLearnplacesPlugin;
use ilPropertyFormGUI;
use ilRadioGroupInputGUI;
use ilRadioOption;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use xsrlContentGUI;

/**
 * Class BlockAddFormGUI
 *
 * Provides the view with the block type selection.
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class BlockAddFormGUI extends ilPropertyFormGUI {

	const POST_BLOCK_TYPES = 'post_block_types';
	const POST_SEQUENCE = 'post_sequence';
	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var ilCtrl $controlFlow
	 */
	private $controlFlow;

	private $mapEnabled = true;
	private $accordionEnabled = true;


	/**
	 * BlockAddFormGUI constructor.
	 *
	 * @param ilLearnplacesPlugin $plugin
	 * @param ilCtrl              $controlFlow
	 */
	public function __construct(ilLearnplacesPlugin $plugin, ilCtrl $controlFlow) {
		parent::__construct();

		$this->plugin = $plugin;
		$this->controlFlow = $controlFlow;
	}


	private function initForm() {

		$this->controlFlow->saveParameterByClass(xsrlContentGUI::class, PlusView::POSITION_QUERY_PARAM);
		$this->controlFlow->saveParameterByClass(xsrlContentGUI::class, PlusView::ACCORDION_QUERY_PARAM);

		$this->setFormAction($this->controlFlow->getFormActionByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX));
		$this->setPreventDoubleSubmission(true);

		//create visibility
		$visibilitySectionHeader = new ilFormSectionHeaderGUI();
		$visibilitySectionHeader->setTitle($this->plugin->txt('block_add_header'));
		$this->addItem($visibilitySectionHeader);

		$accordionOption = new ilRadioOption($this->plugin->txt('block_accordion'), BlockType::ACCORDION);
		$accordionOption->setDisabled(!$this->accordionEnabled);

		$radioGroup = new ilRadioGroupInputGUI($this->plugin->txt('block_type_title'), self::POST_BLOCK_TYPES);
		//$radioGroup->addOption(new ilRadioOption($this->plugin->txt('block_picture_upload'), BlockType::PICTURE_UPLOAD));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('block_picture'), BlockType::PICTURE));
		$radioGroup->addOption($accordionOption);
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('block_ilias_link'), BlockType::ILIAS_LINK));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('block_rich_text'), BlockType::RICH_TEXT));
		$radioGroup->addOption((new ilRadioOption($this->plugin->txt('block_video'), BlockType::VIDEO)));
		$radioGroup->setValue(BlockType::PICTURE);
		$this->addItem($radioGroup);

		$this->initButtons();
	}

	private function initButtons() {
		$this->addCommandButton(CommonControllerAction::CMD_CREATE, $this->plugin->txt('common_add'));
		$this->addCommandButton(CommonControllerAction::CMD_CANCEL, $this->plugin->txt('common_cancel'));
	}


	/**
	 * @param bool $mapEnabled
	 *
	 * @return BlockAddFormGUI
	 */
	public function setMapEnabled(bool $mapEnabled): BlockAddFormGUI {
		$this->mapEnabled = $mapEnabled;

		return $this;
	}


	/**
	 * @param bool $accordionEnabled
	 *
	 * @return BlockAddFormGUI
	 */
	public function setAccordionEnabled(bool $accordionEnabled): BlockAddFormGUI {
		$this->accordionEnabled = $accordionEnabled;

		return $this;
	}


	public function getHTML() {
		$this->initForm();
		return parent::getHTML();
	}
}