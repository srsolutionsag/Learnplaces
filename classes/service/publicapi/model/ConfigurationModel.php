<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\ConfigurationDtoMappingAware;

/**
 * Class ConfigurationModel
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class ConfigurationModel {

	use ConfigurationDtoMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;
	/**
	 * @var bool $online
	 */
	private $online = false;
	/**
	 * @var string $defaultVisibility
	 */
	private $defaultVisibility = "ALWAYS";

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return ConfigurationModel
	 */
	public function setId(int $id): ConfigurationModel {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return bool
	 */
	public function isOnline(): bool {
		return $this->online;
	}


	/**
	 * @param bool $online
	 *
	 * @return ConfigurationModel
	 */
	public function setOnline(bool $online): ConfigurationModel {
		$this->online = $online;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDefaultVisibility(): string {
		return $this->defaultVisibility;
	}


	/**
	 * @param string $defaultVisibility
	 *
	 * @return ConfigurationModel
	 */
	public function setDefaultVisibility(string $defaultVisibility): ConfigurationModel {
		$this->defaultVisibility = $defaultVisibility;

		return $this;
	}

}