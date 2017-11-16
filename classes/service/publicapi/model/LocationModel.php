<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\LocationDtoMappingAware;

/**
 * Class Location
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LocationModel {

	use LocationDtoMappingAware;

	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var float $latitude
	 */
	private $latitude;
	/**
	 * @var float $longitude
	 */
	private $longitude;
	/**
	 * @var float $elevation
	 */
	private $elevation;
	/**
	 * @var int $radius
	 */
	private $radius;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return LocationModel
	 */
	public function setId(int $id): LocationModel {
		$this->id = $id;

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
	 * @return LocationModel
	 */
	public function setLatitude(float $latitude): LocationModel {
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
	 * @return LocationModel
	 */
	public function setLongitude(float $longitude): LocationModel {
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
	 * @return LocationModel
	 */
	public function setElevation(float $elevation): LocationModel {
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
	 * @return LocationModel
	 */
	public function setRadius(int $radius): LocationModel {
		$this->radius = $radius;

		return $this;
	}

}