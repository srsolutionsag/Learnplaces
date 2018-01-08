<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Configuration;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface ConfigurationRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface ConfigurationRepository {

	/**
	 * Creates a new configuration if the id was not found or updates an existing configuration.
	 *
	 * @param Configuration $configuration The configuration which should be updated.
	 *
	 * @return Configuration    The created or updated configuration.
	 */
	public function store(Configuration $configuration): Configuration;


	/**
	 * Searches a configuration with the given id.
	 *
	 * @param int $id The id which should be used to find the configuration.
	 *
	 * @return Configuration    The found configuration.
	 */
	public function find(int $id): Configuration;


	/**
	 * Deletes a configuration by id.
	 *
	 * @param int $id The id which should be used to delete a configuration.
	 *
	 * @return void
	 */
	public function delete(int $id);


	/**
	 * Searches a configuration by the learnplace object id.
	 *
	 * @param int $objectId     The object id which should be used to to find the specific learnplace configuration.
	 *
	 * @return Configuration    The configuration which belongs to the learnplace with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if no learnplace is found for the given object id.
	 */
	public function findByObjectId(int $objectId) : Configuration;
}