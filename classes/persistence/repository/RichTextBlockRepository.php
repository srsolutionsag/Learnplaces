<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\RichTextBlock;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface RichTextBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface RichTextBlockRepository {

	/**
	 * Updates a rich text block or creates a new one if the block was not found.
	 *
	 * @param RichTextBlock $richTextBlock  The rich text block which should be updated or created.
	 *
	 * @return RichTextBlock                The updated or created rich text block.
	 */
	public function store(RichTextBlock $richTextBlock): RichTextBlock;


	/**
	 * Searches the rich text block by block id.
	 *
	 * @param int $id           The id which should be used to search the rich text block.
	 *
	 * @return RichTextBlock    The found rich text block.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if no block with the given id was found.
	 */
	public function findByBlockId(int $id): RichTextBlock;


	/**
	 * Removes a rich text block by id.
	 *
	 * @param int $id   The block id which should be used to remove the block.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if no block with the given id was found.
	 */
	public function delete(int $id);


	/**
	 * Searches all rich text blocks which belong to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search all corresponding rich text blocks.
	 *
	 * @return RichTextBlock[]          All found rich text blocks which belong to the given learnplace.
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}