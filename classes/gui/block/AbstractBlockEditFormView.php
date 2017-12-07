<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block;

use ilFormSectionHeaderGUI;
use ilLearnplacesPlugin;
use ilLinkButton;
use ilPropertyFormGUI;
use ilRadioGroupInputGUI;
use ilRadioOption;
use ilToolbarGUI;
use function in_array;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use SRAG\Learnplaces\util\Visibility;
use xsrlContentGUI;

/**
 * Class xsrlAbstractBlockFormGUI
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
abstract class AbstractBlockEditFormView extends ilPropertyFormGUI {

	const POST_VISIBILITY = "post_visibility";

	private static $validVisibilities = [
		Visibility::ALWAYS,
		Visibility::NEVER,
		Visibility::ONLY_AT_PLACE,
		Visibility::AFTER_VISIT_PLACE,
	];

	/**
	 * @var BlockModel $block
	 */
	private $block;
	/**
	 * @var
	 */
	private $plugin;


	/**
	 * AbstractBlockFormView constructor.
	 *
	 * @param BlockModel $block
	 */
	public function __construct(BlockModel $block) {
		parent::__construct();
		$this->block = $block;
		$this->plugin = ilLearnplacesPlugin::getInstance();
		$this->initForm();
	}

	private function initForm() {

		$this->setFormAction($this->getFormActionUrl());
		$this->setPreventDoubleSubmission(true);

		//create toolbar
		$toolbar = new ilToolbarGUI();
		$button = ilLinkButton::getInstance();
		$button->setCaption($this->plugin->txt('common_delete'));
		$button->setUrl($this->ctrl->getLinkTargetByClass(xsrlContentGUI::class, CommonControllerAction::CMD_DELETE) . '&block=' . $this->block->getId());
		$toolbar->addButtonInstance($button);
		//$this->addItem($toolbar);

		//create visibility
		$visibilitySectionHeader = new ilFormSectionHeaderGUI();
		$visibilitySectionHeader->setTitle($this->plugin->txt('common_visibility'));
		$this->addItem($visibilitySectionHeader);

		$radioGroup = new ilRadioGroupInputGUI($this->plugin->txt('visibility_title'), self::POST_VISIBILITY);
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_always'), Visibility::ALWAYS));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_after_visit_place'), Visibility::AFTER_VISIT_PLACE));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_only_at_place'), Visibility::ONLY_AT_PLACE));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_never'), Visibility::NEVER));
		$this->addItem($radioGroup);

		if($this->hasBlockSpecificParts()) {
			//create block specific settings header
			$visibilitySectionHeader = new ilFormSectionHeaderGUI();
			$visibilitySectionHeader->setTitle($this->plugin->txt('block_specific_settings'));
			$this->addItem($visibilitySectionHeader);
			$this->initBlockSpecificForm();
		}

		$this->initButtons();
	}

	private function initButtons() {
		if($this->block->getId() > 0) {
			$this->addCommandButton(CommonControllerAction::CMD_UPDATE, $this->plugin->txt('common_update'));
			$this->addCommandButton(CommonControllerAction::CMD_CANCEL, $this->plugin->txt('common_cancel'));
			return;
		}

		$this->addCommandButton(CommonControllerAction::CMD_CREATE, $this->plugin->txt('common_create'));
		$this->addCommandButton(CommonControllerAction::CMD_CANCEL, $this->plugin->txt('common_cancel'));
	}


	/**
	 * If this method returns true a block specific config section is rendered.
	 *
	 * @return bool
	 */
	protected abstract function hasBlockSpecificParts(): bool;

	/**
	 * Init block specific gui settings with $this->addItem().
	 * This method is only called if the hasBlockSpecificParts returned true.
	 *
	 * @return void
	 */
	protected abstract function initBlockSpecificForm();


	/**
	 * Fill the block specific part of the gui with the post data.
	 *
	 * @return void
	 */
	protected abstract function fillBlockSpecificFormParts();


	/**
	 * Defines the form action url.
	 *
	 * @return string   The form action url.
	 */
	protected abstract function getFormActionUrl(): string;


	/**
	 * Fill the data of the block gui into the specific block object.
	 *
	 * @return void
	 */
	protected abstract function getObject();

	public function getBlockModel(): BlockModel {
		if(!$this->checkInput())
			throw new ValidationException('Received block content is not valid and got rejected.');

		$visibility = $this->getInput(self::POST_VISIBILITY);
		if(!in_array($visibility, self::$validVisibilities))
			throw new ValidationException('Invalid visibility received!');

		$this->getObject();
		$this->block->setVisibility($visibility);
		return $this->block;
	}


	/**
	 * Fills the form with the data of the block model.
	 *
	 * @return void
	 */
	public function fillForm() {
		$values = [
			self::POST_VISIBILITY => $this->block->getVisibility(),
		];

		$this->setValuesByArray($values);
		$this->fillBlockSpecificFormParts();
	}
}