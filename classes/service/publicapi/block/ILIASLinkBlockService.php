<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\ILIASLinkBlockModel;

/**
 * Interface ILIASLinkBlockService
 *
 * The ILIAS link block service defines the public interface which must be used by
 * the GUI, REST or other Plugins to access the ILIAS link blocks of the learnplace.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface ILIASLinkBlockService {

	/**
	 * Updates an ILIAS link block or creates a new one if the block id was not found.
	 *
	 * @param ILIASLinkBlockModel $blockModel   The block which should be created or updated.
	 *
	 * @return ILIASLinkBlockModel              The newly created or updated block.
	 */
	public function store(ILIASLinkBlockModel $blockModel): ILIASLinkBlockModel;


	/**
	 * Deletes the ILIAS link block with the given id.
	 *
	 * @param int $id   The id of the link block which should be removed.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *                  Thrown if the link block with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches an ILIAS link block with the given id.
	 *
	 * @param int $id               The id of the link block which should be found.
	 *
	 * @return ILIASLinkBlockModel  The ILIAS link block with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                              Thrown if no ILIAS link block was found with the given id.
	 */
	public function find(int $id): ILIASLinkBlockModel;

}