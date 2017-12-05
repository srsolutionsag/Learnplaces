<?php

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
class ilObjLearnplaces extends ilObjectPlugin {

	private $container;

	/**
	 * ilObjLearnLoc2 constructor.
	 *
	 * @param int $ref_id The reference id of the current object.
	 */
	public function __construct($ref_id = 0) {
		global $DIC;

		parent::__construct($ref_id);

		$this->container = $DIC;
	}


	protected function initType() {
		$this->setType(ilLearnplacesPlugin::PLUGIN_ID);
	}


	protected function doCreate() {
		/**
		 * @var LearnplaceService $learnplaceService
		 */
		$learnplaceService = $this->container[LearnplaceService::class];
		/**
		 * @var ConfigurationService $configService
		 */
		$configService = $this->container[ConfigurationService::class];
		/**
		 * @var LocationService $locationService
		 */
		$locationService = $this->container[LocationService::class];

		$location = $locationService->store(new LocationModel());
		$config = $configService->store(new ConfigurationModel());
		$learnplace = new LearnplaceModel();
		$learnplace
			->setLocation($location)
			->setConfiguration($config)
			->setObjectId($this->getId());

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
		$learnplaceService = $this->container[LearnplaceService::class];
		$learnplace = $learnplaceService->findByObjectId($this->getId());
		$learnplaceService->delete($learnplace->getId());
	}


	/**
	 * @inheritdoc
	 */
	protected function doCloneObject($new_obj, $a_target_id, $a_copy_id = null) {
//		throw new Exception("Not Implemented yet.");
	}
}