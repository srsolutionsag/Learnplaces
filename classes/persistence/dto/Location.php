<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class Location
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Location {

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
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Location
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getLatitude() {
		return $this->latitude;
	}


	/**
	 * @param float $latitude
	 *
	 * @return Location
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getLongitude() {
		return $this->longitude;
	}


	/**
	 * @param float $longitude
	 *
	 * @return Location
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;

		return $this;
	}


	/**
	 * @return float
	 */
	public function getElevation() {
		return $this->elevation;
	}


	/**
	 * @param float $elevation
	 *
	 * @return Location
	 */
	public function setElevation($elevation) {
		$this->elevation = $elevation;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getRadius() {
		return $this->radius;
	}


	/**
	 * @param int $radius
	 *
	 * @return Location
	 */
	public function setRadius($radius) {
		$this->radius = $radius;

		return $this;
	}
}