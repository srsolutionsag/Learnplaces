<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\PictureUploadBlock;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

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
	 *
	 * @throws EntityNotFoundException  Thrown if the given block id was not found.
	 */
	public function findByBlockId(int $id): PictureUploadBlock;


	/**
	 * Deletes a picture upload block by its id.
	 *
	 * @param int $id   The id if the block which should be deleted.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException Thrown if the given block id was not found.
	 */
	public function delete(int $id);

	/**
	 * Searches the picture upload blocks for the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to find all picture upload blocks.
	 *
	 * @return PictureUploadBlock       The found picture upload block for the given learnplace.
	 *
	 * @throws EntityNotFoundException  Thrown if the given leanplace has no picture upload block.
	 */
	public function findByLearnplace(Learnplace $learnplace) : PictureUploadBlock;
}