<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class Configuration
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Configuration {

	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var bool $online
	 */
	private $online;
	/**
	 * @var string $defaultVisibility
	 */
	private $defaultVisibility;


	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Configuration
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return bool
	 */
	public function isOnline() {
		return $this->online;
	}


	/**
	 * @param bool $online
	 *
	 * @return Configuration
	 */
	public function setOnline($online) {
		$this->online = $online;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDefaultVisibility() {
		return $this->defaultVisibility;
	}


	/**
	 * @param string $defaultVisibility
	 *
	 * @return Configuration
	 */
	public function setDefaultVisibility($defaultVisibility) {
		$this->defaultVisibility = $defaultVisibility;

		return $this;
	}

}