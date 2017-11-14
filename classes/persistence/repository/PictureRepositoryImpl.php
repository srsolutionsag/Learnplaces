<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use ilDatabaseException;
use SRAG\Learnplaces\persistence\dto\Picture;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class PictureRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureRepositoryImpl implements PictureRepository {

	/**
	 * @inheritdoc
	 */
	public function store(Picture $picture) : Picture {
		$activeRecord = $this->mapToEntity($picture);
		$activeRecord->store();
		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function find(int $id) : Picture {
		try {
			$pictureEntity = \SRAG\Learnplaces\persistence\entity\Picture::findOrFail($id);
			return $this->mapToDTO($pictureEntity);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Picture with id \"$id\" not found.", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$pictureEntity = \SRAG\Learnplaces\persistence\entity\Picture::findOrFail($id);
			$pictureEntity->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Picture with id \"$id\" not found.", $ex);
		}
		catch(ilDatabaseException $ex) {
			throw new ilDatabaseException("Unable to delete picture with id \"$id\"");
		}
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\Picture $pictureEntity) : Picture {

		$picture = new Picture();
		$picture
			->setId($pictureEntity->getPkId())
			->setOriginalPath($pictureEntity->getOriginalPath())
			->setPreviewPath($pictureEntity->getPreviewPath());

		return $picture;
	}

	private function mapToEntity(Picture $picture) : \SRAG\Learnplaces\persistence\entity\Picture {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\Picture $activeRecord
		 */
		$activeRecord = new \SRAG\Learnplaces\persistence\entity\Picture($picture->getId());

		$activeRecord
			->setPkId($picture->getId())
			->setPreviewPath($picture->getPreviewPath())
			->setOriginalPath($picture->getOriginalPath());

		return $activeRecord;
	}
}