<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

/**
 * Class PictureBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
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
	public function getTitle(): string {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return PictureBlock
	 */
	public function setTitle(string $title): PictureBlock {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->description;
	}


	/**
	 * @param string $description
	 *
	 * @return PictureBlock
	 */
	public function setDescription(string $description): PictureBlock {
		$this->description = $description;

		return $this;
	}


	/**
	 * @return Picture
	 */
	public function getPicture(): Picture {
		return $this->picture;
	}


	/**
	 * @param Picture $picture
	 *
	 * @return PictureBlock
	 */
	public function setPicture(Picture $picture): PictureBlock {
		$this->picture = $picture;

		return $this;
	}

}