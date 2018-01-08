<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;

/**
 * Interface PictureBlockService
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface PictureBlockService {

	/**
	 * Updates a given picture block or creates a new one if the picture block with the given id was not found.
	 *
	 * @param PictureBlockModel $blockModel The picture block which should be updated or created.
	 *
	 * @return PictureBlockModel            The newly updated or created picture block model.
	 */
	public function store(PictureBlockModel $blockModel): PictureBlockModel;


	/**
	 * Deletes a picture block by id.
	 *
	 * @param int $id   The id which should be used to delete the picture block.
	 *
	 * @return void
	 * @throws InvalidArgumentException
	 *                  Thrown if the picture block with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches a picture block by id.
	 *
	 * @param int $id               The id which should be used to search the picture block.
	 *
	 * @return PictureBlockModel    The picture block with the given id.
	 */
	public function find(int $id): PictureBlockModel;
}