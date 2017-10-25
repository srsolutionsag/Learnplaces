<?php

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\CrudDao;
use SRAG\Learnplaces\persistence\entity\PictureGalleryEntry;

/**
 * Interface PictureGalleryEntryDao
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface PictureGalleryEntryDao extends CrudDao {

	/**
	 * Finds all gallery entries by the given learnplace id.
	 *
	 * @param int $id The id of the learnplace which should be used to find all the gallery entries.
	 *
	 * @return PictureGalleryEntry[] An array of gallery entries which belong to the given learnplace.
	 */
	public function findByLearnplaceId(int $id): array;
}