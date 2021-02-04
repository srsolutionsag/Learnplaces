<?php
declare(strict_types=1);

use SRAG\Learnplaces\container\PluginContainer;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\LocationService;
use SRAG\Learnplaces\service\publicapi\model\ConfigurationModel;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;
use SRAG\Learnplaces\service\publicapi\model\LocationModel;
use SRAG\Learnplaces\service\publicapi\block\util\BlockOperationDispatcher;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\filesystem\PathHelper;
use SRAG\Learnplaces\service\publicapi\model\PictureModel;
use SRAG\Learnplaces\persistence\repository\PictureRepository;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;

/**
 * Class ilObjLearnplaces
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class ilObjLearnplaces extends ilObjectPlugin {

	/*
	const TRANSLATE_NEWS_TITLE = true;
	const TRANSLATE_NEWS_CONTENT = 0; //has to be a number
	*/

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
		/*
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
		*/
	}


	protected function doRead() {

	}


	protected function doUpdate() {
		/*
		$user = PluginContainer::resolve('ilUser');

		$news = new ilNewsItem(ilNewsItem::getLastNewsIdForContext($this->getId(), $this->getType()));
		$news->setTitle('news_updated');
		$news->setContentIsLangVar(self::TRANSLATE_NEWS_TITLE);
		$news->setContentTextIsLangVar(self::TRANSLATE_NEWS_CONTENT);
		$news->setContent('');
		$news->setUpdateDate($this->getLastUpdateDate());
		$news->setUpdateUserId($user->getId());
		$news->update();
		*/
	}


	protected function doDelete() {
		/**
		 * @var LearnplaceService $learnplaceService
		 */
		$learnplaceService = PluginContainer::resolve(LearnplaceService::class);
		$learnplace = $learnplaceService->findByObjectId(intval($this->getId()));
		$learnplaceService->delete($learnplace->getId());
		// TODO: Delete files on filesystem
	}

    /**
     * @param ilObject2    $new_obj - cloned object
     * @param int          $a_target_id
     * @param int|null     $a_copy_id
     */
	protected function doCloneObject($new_obj, $a_target_id, $a_copy_id = null) {
		/**
		 * @var LearnplaceService $learnplaceService
		 */
		$learnplaceService = PluginContainer::resolve(LearnplaceService::class);

        /**
         * @var ConfigurationService $configurationService
         */
		$configurationService = PluginContainer::resolve(ConfigurationService::class);

        /**
         * @var LocationService $locationService
         */
		$locationService = PluginContainer::resolve(LocationService::class);

        /**
         * @var BlockOperationDispatcher $blockDispatcher
         */
        $blockDispatcher = PluginContainer::resolve(BlockOperationDispatcher::class);

        $newObjectId = intval($new_obj->getId());
        $learnplace = $learnplaceService->findByObjectId(intval($this->getId()));

        // ILIAS calls do create first so we have an empty learnplace with the new object id
        $copyLearnplace = $learnplaceService->findByObjectId($newObjectId);

        //Copy Location
		$locationService->store(
		    $learnplace->getLocation()->setId($copyLearnplace->getLocation()->getId())
        );

        // Copy Object configuration
        $configurationService->store(
            $learnplace->getConfiguration()->setId($copyLearnplace->getConfiguration()->getId())
        );

        // Copy pictures
        $pictures = $learnplace->getPictures();
        $copyPictures = [];
        foreach ($pictures as $picture) {
            $copyPictures[] = $this->copyPictureModel($newObjectId, $picture);
        }
        $copyLearnplace->setPictures($copyPictures);

        // Copy Blocks
        $blocks = $learnplace->getBlocks();
        foreach ($blocks as $block) {
            $block->setId(0);

            // Copy blocks which belong to an accordion
            if ($block instanceof AccordionBlockModel) {
                $accBlocks = $block->getBlocks();
                foreach ($accBlocks as $accBlock) {
                    $accBlock->setId(0);

                    if ($accBlock instanceof VideoBlockModel) {
                        $path = $accBlock->getPath();
                        $coverPath = $accBlock->getCoverPath();

                        $newPath = $this->copyFileToNewObject($newObjectId, $path);
                        $newCoverPath = $this->copyFileToNewObject($newObjectId, $coverPath);

                        $accBlock->setPath($newPath);
                        $accBlock->setCoverPath($newCoverPath);
                    }

                    if ($accBlock instanceof PictureBlockModel) {
                        $accBlock->setPicture($this->copyPictureModel($newObjectId, $accBlock->getPicture()));
                    }
                }

                $copyAccBlocks = $blockDispatcher->storeAll($accBlocks);
                $block->setBlocks($copyAccBlocks);
            }

            if ($block instanceof VideoBlockModel) {
                $path = $block->getPath();
                $coverPath = $block->getCoverPath();

                $newPath = $this->copyFileToNewObject($newObjectId, $path);
                $newCoverPath = $this->copyFileToNewObject($newObjectId, $coverPath);

                $block->setPath($newPath);
                $block->setCoverPath($newCoverPath);
            }

            if ($block instanceof PictureBlockModel) {
                $block->setPicture($this->copyPictureModel($newObjectId, $block->getPicture()));
            }
        }
        $copyBlocks = $blockDispatcher->storeAll($blocks);
        $copyLearnplace->setBlocks($copyBlocks);

		$learnplaceService->store($copyLearnplace);
	}

	private function copyFileToNewObject(int $objectId, string $filePath): string {
	    if (strlen($filePath) === 0) {
	        return '';
        }

        /**
         * @var FilesystemInterface $filesystem
         */
	    $filesystem = PluginContainer::resolve(FilesystemInterface::class);

        $newFilePath = PathHelper::generatePath($objectId, $filePath);

        try {
            if (!$filesystem->copy($filePath, $newFilePath)) {
                throw new \ilException("Copy process of learnplace failed unable to copy: '$filePath' to '$newFilePath'");
            }
        } catch (FileExistsException $ex) {
            // noop file is already there
        } catch (FileNotFoundException $ex) {
            throw new \ilException("Copy process of learnplace failed unable to copy: '$filePath' reason: file not found");
        }

        return $newFilePath;
    }

    private function copyPictureModel(int $newObjectId, PictureModel $picture): PictureModel {
        /**
         * @var PictureRepository $pictureRepository
         */
        $pictureRepository = PluginContainer::resolve(PictureRepository::class);

        $copyPicture = new PictureModel();
        $newOriginalPath = $this->copyFileToNewObject($newObjectId, $picture->getOriginalPath());
        $newPreviewPath = $this->copyFileToNewObject($newObjectId, $picture->getPreviewPath());

        $copyPicture->setOriginalPath($newOriginalPath);
        $copyPicture->setPreviewPath($newPreviewPath);
        return ($pictureRepository->store($copyPicture->toDto()))->toModel();
    }
}