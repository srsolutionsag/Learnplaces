<?php
declare(strict_types=1);

use ILIAS\HTTP\GlobalHttpState;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\gui\settings\SettingEditFormView;
use SRAG\Learnplaces\gui\settings\SettingModel;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\LocationService;

/**
 * Class xsrlSettingGUI
 *
 * @package SRAG\Learnplaces\gui\settings
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlSettingGUI {

	const TAB_ID = 'Settings';
	const BLOCK_ID_QUERY_KEY = 'block';

	/**
	 * @var ilTabsGUI $tabs
	 */
	private $tabs;
	/**
	 * @var ilTemplate $template
	 */
	private $template;
	/**
	 * @var ilCtrl $controlFlow
	 */
	private $controlFlow;
	/**
	 * @var ilAccessHandler $access
	 */
	private $access;
	/**
	 * @var GlobalHttpState $http
	 */
	private $http;
	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var ConfigurationService $configService
	 */
	private $configService;
	/**
	 * @var LocationService $locationService
	 */
	private $locationService;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;


	/**
	 * xsrlSettingGUI constructor.
	 *
	 * @param ilTabsGUI            $tabs
	 * @param ilTemplate           $template
	 * @param ilCtrl               $controlFlow
	 * @param ilAccessHandler      $access
	 * @param GlobalHttpState      $http
	 * @param ilLearnplacesPlugin  $plugin
	 * @param ConfigurationService $configService
	 * @param LocationService      $locationService
	 * @param LearnplaceService    $learnplaceService
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilAccessHandler $access, GlobalHttpState $http, ilLearnplacesPlugin $plugin, ConfigurationService $configService, LocationService $locationService, LearnplaceService $learnplaceService) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->access = $access;
		$this->http = $http;
		$this->plugin = $plugin;
		$this->configService = $configService;
		$this->locationService = $locationService;
		$this->learnplaceService = $learnplaceService;
	}


	public function executeCommand() {

		$this->template->getStandardTemplate();
		$cmd = $this->controlFlow->getCmd(CommonControllerAction::CMD_INDEX);
		$this->tabs->activateTab(self::TAB_ID);

		switch ($cmd) {
			case CommonControllerAction::CMD_EDIT:
			case CommonControllerAction::CMD_UPDATE:
				if ($this->checkRequestReferenceId()) {
					$this->{$cmd}();
				}
				break;
		}
		$this->template->show();

		return true;
	}

	private function checkRequestReferenceId() {
		/**
		 * @var $ilAccess \ilAccessHandler
		 */
		$ref_id = $this->getCurrentRefId();
		if ($ref_id) {
			return $this->access->checkAccess("write", "", $ref_id);
		}

		return true;
	}

	private function getCurrentRefId(): int {
		return intval($this->http->request()->getQueryParams()["ref_id"]);
	}

	private function edit() {
		$learnplce = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		$config = $learnplce->getConfiguration();
		$location = $learnplce->getLocation();
		$model = new SettingModel();
		$model
			->setLatitude($location->getLatitude())
			->setLongitude($location->getLongitude())
			->setRadius($location->getRadius())
			->setElevation($location->getElevation())
			->setOnline($config->isOnline())
			->setDefaultVisibility($config->getDefaultVisibility());

		$view = new SettingEditFormView($model, $this->plugin);
		$view->fillForm();
		$this->template->setContent($view->getHTML());
	}

	private function update() {

		$view = new SettingEditFormView(new SettingModel(), $this->plugin);

		try {
			$learnplce = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
			$config = $learnplce->getConfiguration();
			$location = $learnplce->getLocation();

			$settings = $view->getSettings();
			$config
				->setOnline($settings->isOnline())
				->setDefaultVisibility($settings->getDefaultVisibility());
			$this->configService->store($config);

			$location
				->setLatitude($settings->getLatitude())
				->setLongitude($settings->getLongitude())
				->setElevation($settings->getElevation())
				->setRadius($settings->getRadius());
			$this->locationService->store($location);

			ilUtil::sendSuccess($this->plugin->txt('message_changes_save_success'), true);
			$this->controlFlow->redirect($this, CommonControllerAction::CMD_EDIT);
		}
		catch (ValidationException $ex) {
			$view->setValuesByPost();
			$this->template->setContent($view->getHTML());
		}
	}
}