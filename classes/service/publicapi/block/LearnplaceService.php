<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use LogicException;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;

/**
 * Interface LearnplaceService
 *
 * The external stream block service defines the public interface which must be used by
 * the GUI, REST or other Plugins to access the external stream blocks of the learnplace.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface LearnplaceService {

	/**
	 * Deletes a learnplace by id.
	 *
	 * @param int $id   The id of the leanplace which should be deleted.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *                  Thrown if the id of the learnplace was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches a learnplace by the object id of the learnplace repository objects.
	 *
	 * @param int $objectId         The object id of the repository object which should be used to search the learnplace.s
	 *
	 * @return LearnplaceModel      The learnplace which owns the given object id.
	 *
	 * @throws InvalidArgumentException
	 *                              Thrown if the id of the learnplace was not found.
	 */
	public function findByObjectId(int $objectId): LearnplaceModel;


	/**
	 * Updates the given leanplace or creates a new one if the given learnplace was not found.
	 *
	 * @param LearnplaceModel $learnplaceModel  The leanplace which should be updated or created.
	 *
	 * @return LearnplaceModel                  The newly created or updated learnplace.
	 * @throws LogicException                   Thrown if one of the children of the learnplace is not persistent (children are for example Configuration).
	 */
	public function store(LearnplaceModel $learnplaceModel): LearnplaceModel;


	/**
	 * Searches a learnplace by id.
	 *
	 * @param int $id           The id of the learnplace which should be found.
	 *
	 * @return LearnplaceModel  The learnplace with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                          Thrown if the id of the learnplace was not found.
	 */
	public function find(int $id): LearnplaceModel;

}