<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\gui\block\util\ReferenceIdAware;
use SRAG\Learnplaces\gui\exception\ValidationException;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\gui\settings\SettingEditFormView;
use SRAG\Learnplaces\gui\settings\SettingModel;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\LocationService;
use SRAG\Learnplaces\service\security\AccessGuard;

/**
 * Class xsrlSettingGUI
 *
 * @package SRAG\Learnplaces\gui\settings
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlSettingGUI {

	use ReferenceIdAware;

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
	 * @var ServerRequestInterface $request
	 */
	private $request;
	/**
	 * @var AccessGuard $accessGuard
	 */
	private $accessGuard;


	/**
	 * xsrlSettingGUI constructor.
	 *
	 * @param ilTabsGUI              $tabs
	 * @param ilTemplate             $template
	 * @param ilCtrl                 $controlFlow
	 * @param ilLearnplacesPlugin    $plugin
	 * @param ConfigurationService   $configService
	 * @param LocationService        $locationService
	 * @param LearnplaceService      $learnplaceService
	 * @param ServerRequestInterface $request
	 * @param AccessGuard            $accessGuard
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilLearnplacesPlugin $plugin, ConfigurationService $configService, LocationService $locationService, LearnplaceService $learnplaceService, ServerRequestInterface $request, AccessGuard $accessGuard) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->plugin = $plugin;
		$this->configService = $configService;
		$this->locationService = $locationService;
		$this->learnplaceService = $learnplaceService;
		$this->request = $request;
		$this->accessGuard = $accessGuard;
	}


	public function executeCommand() {

		$this->template->getStandardTemplate();
		$cmd = $this->controlFlow->getCmd(CommonControllerAction::CMD_INDEX);
		$this->tabs->activateTab(self::TAB_ID);

		switch ($cmd) {
			case CommonControllerAction::CMD_CANCEL:
			case CommonControllerAction::CMD_EDIT:
			case CommonControllerAction::CMD_UPDATE:
				if ($this->accessGuard->hasWritePermission()) {
					$this->{$cmd}();
					$this->template->show();
					return true;
				}
				break;
		}

		ilUtil::sendFailure($this->plugin->txt('common_access_denied'), true);
		$this->controlFlow->redirectByClass(ilRepositoryGUI::class);

		return false;
	}

	private function edit() {
		$learnplce = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		$config = $learnplce->getConfiguration();
		$location = $learnplce->getLocation();
		$objectId = ilObject::_lookupObjectId($this->getCurrentRefId());
		$model = new SettingModel();
		$model
			->setLatitude($location->getLatitude())
			->setLongitude($location->getLongitude())
			->setRadius($location->getRadius())
			->setElevation($location->getElevation())
			->setOnline($config->isOnline())
			->setDefaultVisibility($config->getDefaultVisibility())
			->setTitle(ilObject::_lookupTitle($objectId))
			->setDescription(ilObject::_lookupDescription($objectId))
			->setMapZoom($config->getMapZoomLevel());

		$view = new SettingEditFormView($model, $this->plugin, $this->controlFlow);
		$view->fillForm();
		$this->template->setContent($view->getHTML());
	}

	private function update() {

		$view = new SettingEditFormView(new SettingModel(), $this->plugin, $this->controlFlow);

		try {
			$learnplce = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
			$config = $learnplce->getConfiguration();
			$location = $learnplce->getLocation();

			$settings = $view->getSettings();
			$config
				->setOnline($settings->isOnline())
				->setDefaultVisibility($settings->getDefaultVisibility())
				->setMapZoomLevel($settings->getMapZoom());
			$this->configService->store($config);

			$location
				->setLatitude($settings->getLatitude())
				->setLongitude($settings->getLongitude())
				->setElevation($settings->getElevation())
				->setRadius($settings->getRadius());
			$this->locationService->store($location);

			$pluginObject = new ilObjLearnplaces($this->getCurrentRefId());
			$pluginObject->setTitle($settings->getTitle());
			$pluginObject->setDescription($settings->getDescription());
			$pluginObject->update();

			ilUtil::sendSuccess($this->plugin->txt('message_changes_save_success'), true);
			$this->controlFlow->redirect($this, CommonControllerAction::CMD_EDIT);
		}
		catch (ValidationException $ex) {
			$view->setValuesByPost();
			$this->template->setContent($view->getHTML());
		}
	}

	private function cancel() {
		$this->controlFlow->redirectByClass(xsrlContentGUI::class, CommonControllerAction::CMD_INDEX);
	}
}