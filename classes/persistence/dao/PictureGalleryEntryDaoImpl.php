<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\AbstractCrudDao;
use SRAG\Learnplaces\persistence\entity\PictureGalleryEntry;

/**
 * Class PictureGalleryEntryDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureGalleryEntryDaoImpl extends AbstractCrudDao implements PictureGalleryEntryDao {

	/**
	 * PictureGalleryEntryDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(PictureGalleryEntry::class);
	}


	/**
	 * Finds all gallery entries by the given learnplace id.
	 *
	 * @param int $id The id of the learnplace which should be used to find all the gallery entries.
	 *
	 * @return PictureGalleryEntry[] An array of gallery entries which belong to the given learnplace.
	 */
	public function findByLearnplaceId(int $id): array
	{
		$recordList = PictureGalleryEntry::where(['fk_learnplace_id' => $id]);
		return $recordList->get();
	}
}