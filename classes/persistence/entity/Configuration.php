<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\entity;

use ActiveRecord;

/**
 * Class Configuration
 *
 * @package SRAG\Learnplaces\persistence\entity
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Configuration extends ActiveRecord {

	/**
	 * @return string
	 */
	static function returnDbTableName() : string {
		return 'xsrl_configuration';
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
	 * @con_length     1
	 */
	protected $online;
	/**
	 * @var int
	 *
	 * @con_has_field  true
	 * @con_is_notnull true
	 * @con_fieldtype  integer
	 * @con_length     8
	 */
	protected $fk_visibility_default;


	/**
	 * @return int
	 */
	public function getPkId(): int {
		return $this->pk_id;
	}


	/**
	 * @param int $pk_id
	 *
	 * @return Configuration
	 */
	public function setPkId(int $pk_id): Configuration {
		$this->pk_id = $pk_id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getOnline(): int {
		return $this->online;
	}


	/**
	 * @param int $online
	 *
	 * @return Configuration
	 */
	public function setOnline(int $online): Configuration {
		$this->online = $online;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getFkVisibilityDefault(): int {
		return $this->fk_visibility_default;
	}


	/**
	 * @param int $fk_visibility_default
	 *
	 * @return Configuration
	 */
	public function setFkVisibilityDefault(int $fk_visibility_default): Configuration {
		$this->fk_visibility_default = $fk_visibility_default;

		return $this;
	}
}