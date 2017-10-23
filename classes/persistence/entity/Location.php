<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class Location
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Location extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_location';
	}

	/**
	 * @var int
	 *
	 * @con_is_primary true
	 * @con_is_unique  true
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $pk_id;

	/**
	 * @var float
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  float
	 */
	protected $latitude;

	/**
	 * @var float
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  float
	 */
	protected $longitude;

	/**
	 * @var float
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  float
	 */
	protected $elevation;

	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $radius;

	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_learnplace_id;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
	}


	/**
	 * @param int $pk_id
	 *
	 * @return Location
	 */
	public function setPkId(int $pk_id): Location {
		$this->pk_id = $pk_id;

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


	/**
	 * @return int
	 */
	public function getFkLearnplaceId(): int {
		return $this->fk_learnplace_id;
	}


	/**
	 * @param int $fk_learnplace_id
	 *
	 * @return Location
	 */
	public function setFkLearnplaceId(int $fk_learnplace_id): Location {
		$this->fk_learnplace_id = $fk_learnplace_id;

		return $this;
	}

}