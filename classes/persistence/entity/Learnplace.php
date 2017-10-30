<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class Learnplace
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Learnplace extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_learnplace';
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
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_configuration;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_unique  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_object_id;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
	}


	/**
	 * @param int $pk_id
	 *
	 * @return Learnplace
	 */
	public function setPkId(int $pk_id): Learnplace {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkConfiguration(): int {
		return $this->fk_configuration;
	}


	/**
	 * @param int $fk_configuration
	 *
	 * @return Learnplace
	 */
	public function setFkConfiguration(int $fk_configuration): Learnplace {
		$this->fk_configuration = $fk_configuration;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkObjectId(): int {
		return $this->fk_object_id;
	}


	/**
	 * @param int $fk_object_id
	 *
	 * @return Learnplace
	 */
	public function setFkObjectId(int $fk_object_id): Learnplace {
		$this->fk_object_id = $fk_object_id;

		return $this;
	}

}