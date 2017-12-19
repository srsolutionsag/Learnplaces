<?php
declare(strict_types=1);

use SRAG\Learnplaces\container\PluginContainer;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\LocationService;
use SRAG\Learnplaces\service\publicapi\model\ConfigurationModel;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;
use SRAG\Learnplaces\service\publicapi\model\LocationModel;

/**
 * Class ilObjLearnplaces
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class ilObjLearnplaces extends ilObjectPlugin {

	protected function initType() {
		$this->setType(ilLearnplacesPlugin::PLUGIN_ID);
	}

	protected function doCreate() {
		/**
		 * @var LearnplaceService $learnplaceService
		 */
		$learnplaceService = PluginContainer::resolve(LearnplaceService::class);
		/**
		 * @var ConfigurationService $configService
		 */
		$configService = PluginContainer::resolve(ConfigurationService::class);
		/**
		 * @var LocationService $locationService
		 */
		$locationService = PluginContainer::resolve(LocationService::class);

		$location = $locationService->store(new LocationModel());
		$config = $configService->store(new ConfigurationModel());
		$learnplace = new LearnplaceModel();
		$learnplace
			->setLocation($location)
			->setConfiguration($config)
			->setObjectId(intval($this->getId()));

		$learnplaceService->store($learnplace);
	}


	protected function doRead() {

	}


	protected function doUpdate() {

	}


	protected function doDelete() {
		/**
		 * @var LearnplaceService $learnplaceService
		 */
		$learnplaceService = PluginContainer::resolve(LearnplaceService::class);
		$learnplace = $learnplaceService->findByObjectId(intval($this->getId()));
		$learnplaceService->delete($learnplace->getId());
	}


	/**
	 * @inheritdoc
	 */
	protected function doCloneObject($new_obj, $a_target_id, $a_copy_id = null) {
//		throw new Exception("Not Implemented yet.");
	}
}