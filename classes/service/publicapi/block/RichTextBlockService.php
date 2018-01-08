<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\RichTextBlockModel;

/**
 * Interface RichTextBlockService
 *
 * This interface defines the public available operations which must be
 * used to manipulate the video block.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface RichTextBlockService {

	/**
	 * Updates a rich text block or creates a new one if the block id was not found.
	 *
	 * @param RichTextBlockModel $richTextBlockModel    The block which should be created or updated.
	 *
	 * @return RichTextBlockModel                       The newly updated or created block.
	 */
	public function store(RichTextBlockModel $richTextBlockModel): RichTextBlockModel;


	/**
	 * Deletes a rich text by id.
	 *
	 * @param int $id   The id of the rich text block which should be deleted.
	 *
	 * @return void
	 * @throws InvalidArgumentException
	 *                  Thrown if the rich text block with the given id does not exist.
	 */
	public function delete(int $id);


	/**
	 * Searches the rich text block with the given id.
	 * 
	 * @param int $id               The id of the rich text block which should be found.
	 *
	 * @return RichTextBlockModel   The rich text block with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                              Thrown if the id of the rich text block was not found.
	 */
	public function find(int $id): RichTextBlockModel;

}