<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\AudioBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface AudioBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface AudioBlockRepository {

	/**
	 * Updates an audio block or creates a new one if the audio block id was not found.
	 *
	 * @param AudioBlock $audioBlock    The audio block which should be updated or created.
	 *
	 * @return AudioBlock               The updated or created audio block.
	 */
	public function store(AudioBlock $audioBlock): AudioBlock;


	/**
	 * Searches an audio block by block id.
	 *
	 * @param int $id       The block id which should be used to search the audio block.
	 *
	 * @return AudioBlock   The found audio block.
	 *
	 * @throws EntityNotFoundException
	 *                      Thrown if no block with the given id was found.
	 */
	public function findByBlockId(int $id): AudioBlock;


	/**
	 * Deletes the audio block with the given id.
	 *
	 * @param int $id   The of the audio block which should be removed.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the audio block with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches all audio blocks which belongs to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to fetch all corresponding audio blocks.
	 *
	 * @return AudioBlock[]             All found audio blocks.
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}