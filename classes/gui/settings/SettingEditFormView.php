<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\settings;

use ilCheckboxInputGUI;
use ilCtrl;
use ilFormSectionHeaderGUI;
use ilLearnplacesPlugin;
use ilLocationInputGUI;
use ilPropertyFormGUI;
use ilRadioGroupInputGUI;
use ilRadioOption;
use ilTextAreaInputGUI;
use ilTextInputGUI;
use function intval;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\util\Visibility;
use function doubleval;
use xsrlSettingGUI;

/**
 * Class SettingEditFormView
 *
 * @package SRAG\Learnplaces\gui\settings
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class SettingEditFormView extends ilPropertyFormGUI {

	const POST_ONLINE = 'post_online';
	const POST_DEFAULT_VISIBILITY = 'post_default_visibility';
	const POST_LOCATION = 'post_location';
	const POST_LOCATION_RADIUS = 'post_location_radius';
	const POST_TITLE = 'post_title';
	const POST_DESCRIPTION = 'post_description';

	private static $validVisibilities = [
		Visibility::ALWAYS,
		Visibility::NEVER,
		Visibility::ONLY_AT_PLACE,
		Visibility::AFTER_VISIT_PLACE,
	];

	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var SettingModel $configuration
	 */
	private $configuration;
	/**
	 * @var ilCtrl $controlFlow
	 */
	private $controlFlow;


	/**
	 * SettingEditFormView constructor.
	 *
	 * @param SettingModel        $setting
	 * @param ilLearnplacesPlugin $plugin
	 * @param ilCtrl              $controlFlow
	 */
	public function __construct(SettingModel $setting, ilLearnplacesPlugin $plugin, ilCtrl $controlFlow) {
		parent::__construct();
		$this->configuration = $setting;
		$this->plugin = $plugin;
		$this->controlFlow = $controlFlow;
		$this->initForm();
	}

	private function initForm() {

		$this->setFormAction($this->controlFlow->getFormActionByClass(xsrlSettingGUI::class, CommonControllerAction::CMD_EDIT));
		$this->setPreventDoubleSubmission(true);
		$this->setShowTopButtons(false);


		//create general
		$generalSectionHeader = new ilFormSectionHeaderGUI();
		$generalSectionHeader->setTitle($this->plugin->txt('setting_general'));
		$this->addItem($generalSectionHeader);

		$title = new ilTextInputGUI( $this->plugin->txt('common_title'), self::POST_TITLE);
		$title->setRequired(true);
		$this->addItem($title);

		$description = new ilTextAreaInputGUI( $this->plugin->txt('common_description'), self::POST_DESCRIPTION);
		$this->addItem($description);

		$online = new ilCheckboxInputGUI($this->plugin->txt('common_online'), self::POST_ONLINE);
		$online->setRequired(true);
		$this->addItem($online);

		//create visibility
		$visibilitySectionHeader = new ilFormSectionHeaderGUI();
		$visibilitySectionHeader->setTitle($this->plugin->txt('common_visibility'));
		$this->addItem($visibilitySectionHeader);

		$radioGroup = new ilRadioGroupInputGUI($this->plugin->txt('visibility_title'), self::POST_DEFAULT_VISIBILITY);
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_always'), Visibility::ALWAYS));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_after_visit_place'), Visibility::AFTER_VISIT_PLACE));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_only_at_place'), Visibility::ONLY_AT_PLACE));
		$radioGroup->addOption(new ilRadioOption($this->plugin->txt('visibility_never'), Visibility::NEVER));
		$radioGroup->setRequired(true);
		$this->addItem($radioGroup);

		//location settings
		$locationSectionHeader = new ilFormSectionHeaderGUI();
		$locationSectionHeader->setTitle($this->plugin->txt('setting_location'));
		$this->addItem($locationSectionHeader);

		$radius = new ilTextInputGUI($this->plugin->txt('setting_radius'), self::POST_LOCATION_RADIUS);
		$radius->setRequired(true);
		/*
		 * Range between 1m and 40 km
		 */
		$radius->setValidationRegexp('/^(?:[1-9]|3?\d{2,4}|40{4})$/');
		$radius->setValidationFailureMessage($this->plugin->txt('setting_validation_failure_radius'));
		$radius->setInfo($this->plugin->txt('setting_radius_info'));
		$this->addItem($radius);

		$location = new ilLocationInputGUI($this->plugin->txt('setting_location'), self::POST_LOCATION);
		$location->setRequired(true);
		$this->addItem($location);

		$this->initButtons();
	}

	private function initButtons() {
		$this->addCommandButton(CommonControllerAction::CMD_UPDATE, $this->plugin->txt('common_save'));
		$this->addCommandButton(CommonControllerAction::CMD_CANCEL, $this->plugin->txt('common_cancel'));
	}

	public function getSettings(): SettingModel {
		if(!$this->checkInput())
			throw new ValidationException('Received configuration content is not valid and got rejected.');

		$visibility = $this->getInput(self::POST_DEFAULT_VISIBILITY);
		if(!in_array($visibility, self::$validVisibilities))
			throw new ValidationException('Invalid visibility received!');

		$this->configuration->setDefaultVisibility($visibility);
		$this->configuration->setLongitude(doubleval($this->getInput(self::POST_LOCATION)['longitude']));
		$this->configuration->setLatitude(doubleval($this->getInput(self::POST_LOCATION)['latitude']));
		$this->configuration->setOnline(intval($this->getInput(self::POST_ONLINE)) === 1);
		$this->configuration->setRadius(intval($this->getInput(self::POST_LOCATION_RADIUS)));
		$this->configuration->setElevation(0);
		$this->configuration->setTitle($this->getInput(self::POST_TITLE));
		$this->configuration->setDescription($this->getInput(self::POST_DESCRIPTION));
		return $this->configuration;
	}


	/**
	 * Fills the form with the data of the block model.
	 *
	 * @return void
	 */
	public function fillForm() {
		$values = [
			self::POST_DEFAULT_VISIBILITY   => $this->configuration->getDefaultVisibility(),
			self::POST_ONLINE               => $this->configuration->isOnline(),
			self::POST_LOCATION             => ['latitude' => $this->configuration->getLatitude(), 'longitude' => $this->configuration->getLongitude()],
			self::POST_LOCATION_RADIUS      => $this->configuration->getRadius(),
			self::POST_TITLE                => $this->configuration->getTitle(),
			self::POST_DESCRIPTION          =>$this->configuration->getDescription(),
		];

		$this->setValuesByArray($values);
	}
}