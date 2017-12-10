<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block;

use function array_merge_clobber;
use ilFormSectionHeaderGUI;
use ilHiddenInputGUI;
use ilLearnplacesPlugin;
use ilLinkButton;
use ilPropertyFormGUI;
use ilRadioGroupInputGUI;
use ilRadioOption;
use function in_array;
use function intval;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use SRAG\Learnplaces\util\Visibility;

/**
 * Class xsrlAbstractBlockFormGUI
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
abstract class AbstractBlockEditFormView extends ilPropertyFormGUI {

	const POST_VISIBILITY = "post_visibility";
	const POST_ID = 'post_id';

	private static $validVisibilities = [
		Visibility::ALWAYS,
		Visibility::NEVER,
		Visibility::ONLY_AT_PLACE,
		Visibility::AFTER_VISIT_PLACE,
	];

	/**
	 * @var BlockModel $block
	 */
	protected $block;

	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	protected $plugin;


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
		$this->setShowTopButtons(false);

		$id = new ilHiddenInputGUI(self::POST_ID);
		$id->setRequired(true);
		$this->addItem($id);

		//create visibility
		$visibilitySectionHeader = new ilFormSectionHeaderGUI();
		$visibilitySectionHeader->setTitle($this->plugin->txt('common_visibility'));
		$this->addItem($visibilitySectionHeader);

		$radioGroup = new ilRadioGroupInputGUI($this->plugin->txt('visibility_title'), self::POST_VISIBILITY);
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_always'), Visibility::ALWAYS));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_after_visit_place'), Visibility::AFTER_VISIT_PLACE));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_only_at_place'), Visibility::ONLY_AT_PLACE));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_never'), Visibility::NEVER));
		$radioGroup->setRequired(true);
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
			$this->addCommandButton(CommonControllerAction::CMD_UPDATE, $this->plugin->txt('common_save'));
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
	 * Creates an array for the block specific form parts.
	 *
	 * Example:
	 * [
	 *      'POST_TEXT_INPUT' => 'Some text for this field',
	 * ]
	 *
	 * @return array
	 */
	protected abstract function createValueArrayForSpecificFormParts(): array;


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
		$this->block->setId(intval($this->getInput(self::POST_ID)));
		return $this->block;
	}


	/**
	 * Fills the form with the data of the block model.
	 *
	 * @return void
	 */
	public function fillForm() {
		$values = [
			self::POST_ID => $this->block->getId(),
			self::POST_VISIBILITY => $this->block->getVisibility(),
		];

		$allValues = array_merge($values, $this->createValueArrayForSpecificFormParts());

		$this->setValuesByArray($allValues);
	}
}