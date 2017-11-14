<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\VideoBlock;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface VideoBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface VideoBlockRepository {

	/**
	 * Updates a video block or creates a new one if the block id was not found.
	 *
	 * @param VideoBlock $videoBlock    The video block which should be updated or created.
	 *
	 * @return VideoBlock               The updated or created video block.
	 */
	public function store(VideoBlock $videoBlock): VideoBlock;


	/**
	 * Searches a video block with the given id.
	 *
	 * @param int $id       The id which should be used to search the video block.
	 *
	 * @return VideoBlock   The found video block with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                      Thrown if the video block with the given id was not found.
	 */
	public function findByBlockId(int $id): VideoBlock;


	/**
	 * Removes the video block with the given id.
	 *
	 * @param int $id   The id which should be used to remove the video block.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  thrown if the video block with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches all video blocks which belong to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search all corresponding video blocks.
	 *
	 * @return VideoBlock[]             All found video blocks.
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}