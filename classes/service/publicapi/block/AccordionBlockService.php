<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;

/**
 * Interface AccordionBlockService
 *
 * The accordion block service defines the public interface which must be used by
 * the GUI, REST or other Plugins to access the accordion blocks of the learnplace.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface AccordionBlockService {

	/**
	 * Updates an existing accordion block or creates a new one if the accordion id was not found.
	 *
	 * @param AccordionBlockModel $blockModel   The block which should be updated or deleted.
	 *
	 * @return AccordionBlockModel              The newly updated or created block.
	 *
	 * @throws InvalidArgumentException         Thrown if one of the child blocks are not persistent.
	 */
	public function store(AccordionBlockModel $blockModel): AccordionBlockModel;


	/**
	 * Deletes an accordion by id.
	 * Please note that the accordion block wont remove its children.
	 * All children will belong to the learnplace it self after the accordion block has been deleted.
	 *
	 * @param int $id   The id of the accordion block which should be deleted.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *                  Thrown if the id of the accordion block was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches an accordion block by id.
	 *
	 * @param int $id               The id of the accordion block which should be found.
	 *
	 * @return AccordionBlockModel  The accordion block with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                              Thrown if the accordion block with the given id was not found.
	 */
	public function find(int $id): AccordionBlockModel;

}