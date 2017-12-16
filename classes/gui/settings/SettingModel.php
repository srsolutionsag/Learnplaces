<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\settings;

/**
 * Class SettingModel
 *
 * @package SRAG\Learnplaces\gui\settings
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class SettingModel {

	/**
	 * @var bool $online
	 */
	private $online = false;
	/**
	 * @var string $defaultVisibility
	 */
	private $defaultVisibility = "ALWAYS";
	/**
	 * @var float $latitude
	 */
	private $latitude = 0.0;
	/**
	 * @var float $longitude
	 */
	private $longitude = 0.0;
	/**
	 * @var float $elevation
	 */
	private $elevation = 0.0;
	/**
	 * @var int $radius
	 */
	private $radius = 200;


	/**
	 * @return bool
	 */
	public function isOnline(): bool {
		return $this->online;
	}


	/**
	 * @param bool $online
	 *
	 * @return SettingModel
	 */
	public function setOnline(bool $online): SettingModel {
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
	 * @return SettingModel
	 */
	public function setDefaultVisibility(string $defaultVisibility): SettingModel {
		$this->defaultVisibility = $defaultVisibility;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getLatitude(): float {
		return $this->latitude;
	}


	/**
	 * @param float $latitude
	 *
	 * @return SettingModel
	 */
	public function setLatitude(float $latitude): SettingModel {
		$this->latitude = $latitude;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getLongitude(): float {
		return $this->longitude;
	}


	/**
	 * @param float $longitude
	 *
	 * @return SettingModel
	 */
	public function setLongitude(float $longitude): SettingModel {
		$this->longitude = $longitude;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getElevation(): float {
		return $this->elevation;
	}


	/**
	 * @param float $elevation
	 *
	 * @return SettingModel
	 */
	public function setElevation(float $elevation): SettingModel {
		$this->elevation = $elevation;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getRadius(): int {
		return $this->radius;
	}


	/**
	 * @param int $radius
	 *
	 * @return SettingModel
	 */
	public function setRadius(int $radius): SettingModel {
		$this->radius = $radius;

		return $this;
	}
}