<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\LocationModelMappingAware;

/**
 * Class Location
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Location {

	use LocationModelMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;
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
	private $radius = 0;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Location
	 */
	public function setId(int $id): Location {
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
	 * @return Location
	 */
	public function setLatitude(float $latitude): Location {
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
	 * @return Location
	 */
	public function setLongitude(float $longitude): Location {
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
	 * @return Location
	 */
	public function setElevation(float $elevation): Location {
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
	 * @return Location
	 */
	public function setRadius(int $radius): Location {
		$this->radius = $radius;

		return $this;
	}

}