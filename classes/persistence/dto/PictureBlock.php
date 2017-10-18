<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class PictureBlock
 *
 * @package StuderRaimannCh\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureBlock extends Block {

	/**
	 * @var string $title
	 */
	private $title;
	/**
	 * @var string $description
	 */
	private $description;
	/**
	 * @var Picture $picture
	 */
	private $picture;


	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return PictureBlock
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}


	/**
	 * @param string $description
	 *
	 * @return PictureBlock
	 */
	public function setDescription($description) {
		$this->description = $description;

		return $this;
	}


	/**
	 * @return Picture
	 */
	public function getPicture() {
		return $this->picture;
	}


	/**
	 * @param Picture $picture
	 *
	 * @return PictureBlock
	 */
	public function setPicture($picture) {
		$this->picture = $picture;

		return $this;
	}
}