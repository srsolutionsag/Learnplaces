<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\PictureUploadBlock;

/**
 * Interface PictureUploadBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface PictureUploadBlockRepository {

	/**
	 * Updates a picture upload block or creates a new one if the id of the block was not found.
	 *
	 * @param PictureUploadBlock $pictureUploadBlock    The picture upload block which should updated or created.
	 *
	 * @return PictureUploadBlock                       The newly updated or created picture upload.
	 */
	public function store(PictureUploadBlock $pictureUploadBlock): PictureUploadBlock;


	/**
	 * Find a picture upload block by block id.
	 *
	 * @param int $id                   The id of the block which should be found.
	 *
	 * @return PictureUploadBlock       The found picture upload block.
	 */
	public function findByBlockId(int $id): PictureUploadBlock;


	/**
	 * Deletes a picture upload block by its id.
	 *
	 * @param int $id   The id if the block which should be deleted.
	 *
	 * @return void
	 */
	public function delete(int $id);
}