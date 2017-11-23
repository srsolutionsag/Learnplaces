<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\ExternalStreamBlockModel;

/**
 * Interface ExternalStreamBlockService
 *
 * The external stream block service defines the public interface which must be used by
 * the GUI, REST or other Plugins to access the external stream blocks of the learnplace.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface ExternalStreamBlockService {

	/**
	 * Updates an external stream block or creates a new one if the id of the block was not found.
	 *
	 * @param ExternalStreamBlockModel $blockModel  The block which should updated or created.
	 *
	 * @return ExternalStreamBlockModel             The newly created or updated block.
	 */
	public function store(ExternalStreamBlockModel $blockModel): ExternalStreamBlockModel;


	/**
	 * Deletes the external stream block by id.
	 *
	 * @param int $id   The id of the block which should be deleted.
	 *
	 * @return void
	 * @throws InvalidArgumentException
	 *                  Thrown if the block with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches an external stream block by id,
	 *
	 * @param int $id                       The id of the block which should be used to search.
	 *
	 * @return ExternalStreamBlockModel     The external stream block with the given id.
	 *
	 * @throws InvalidArgumentException     Thrown if the block with the given id was not found.
	 */
	public function find(int $id): ExternalStreamBlockModel;

}