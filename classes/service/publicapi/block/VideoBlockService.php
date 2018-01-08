<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;

/**
 * Interface VideoBlockService
 *
 * This interface defines the public available operations which must be
 * used to manipulate the video block.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface VideoBlockService {

	/**
	 * Updates a video block or creates a new one if the video block id was not found.
	 *
	 * @param VideoBlockModel $blockModel   The block which should be updated or created.
	 *
	 * @return VideoBlockModel              The newly created or updated video block.
	 */
	public function store(VideoBlockModel $blockModel): VideoBlockModel;


	/**
	 * Deletes a video block by id.
	 *
	 * @param int $id           The id of the video block which should be deleted.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *                          Thrown if the video block with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches a video block by id.
	 *
	 * @param int $id           The id of the video block which should be used to search after the block.
	 *
	 * @return VideoBlockModel  The video block with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                          Thrown if the video block with the given id does not exist.
	 */
	public function find(int $id): VideoBlockModel;
}