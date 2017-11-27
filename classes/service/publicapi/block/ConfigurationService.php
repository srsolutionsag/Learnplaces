<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\ConfigurationModel;

/**
 * Interface ConfigurationService
 *
 * The configuration service defines the public interface which must be used by
 * the GUI, REST or other Plugins to access the configuration of the learnplace.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface ConfigurationService {

	/**
	 * Updates an existing configuration of creates a new one if the id of the configuration was not found.
	 *
	 * @param ConfigurationModel $configurationModel    The configuration which should be updated or created.
	 *
	 * @return ConfigurationModel                       The newly updated or created configuration.
	 */
	public function store(ConfigurationModel $configurationModel): ConfigurationModel;


	/**
	 * Deletes the configuration by id.
	 *
	 * @param int $id   The of the configuration which should be deleted.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *                  Thrown if the configuration with the given id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches a configuration by id.
	 *
	 * @param int $id               The if of the configuration which should be found.
	 *
	 * @return ConfigurationModel   The configuration with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                              Thrown if the configuration with the given id was not found.
	 */
	public function find(int $id): ConfigurationModel;
}