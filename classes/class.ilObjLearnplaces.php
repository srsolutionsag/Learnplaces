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

	const TRANSLATE_NEWS_TITLE = true;
	const TRANSLATE_NEWS_CONTENT = 0; //has to be a number

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
		$news = new ilNewsItem();
		$news->setUserId($this->getOwner());
		$news->setTitle('news_created');
		$news->setContentIsLangVar(self::TRANSLATE_NEWS_TITLE);
		$news->setContentTextIsLangVar(self::TRANSLATE_NEWS_CONTENT);
		$news->setContent('');
		$news->setContextObjId($this->getId());
		$news->setContextObjType($this->getType());
		$news->setCreationDate($this->getCreateDate());
		$news->create();
	}


	protected function doRead() {

	}


	protected function doUpdate() {
		$user = PluginContainer::resolve('ilUser');

		$news = new ilNewsItem(ilNewsItem::getLastNewsIdForContext($this->getId(), $this->getType()));
		$news->setTitle('news_updated');
		$news->setContentIsLangVar(self::TRANSLATE_NEWS_TITLE);
		$news->setContentTextIsLangVar(self::TRANSLATE_NEWS_CONTENT);
		$news->setContent('');
		$news->setUpdateDate($this->getLastUpdateDate());
		$news->setUpdateUserId($user->getId());
		$news->update();
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