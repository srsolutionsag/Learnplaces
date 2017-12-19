<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\PictureBlockDtoMappingAware;

/**
 * Class PictureBlock
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PictureBlockModel extends BlockModel {

	use PictureBlockDtoMappingAware;

	/**
	 * @var string $title
	 */
	private $title = "";
	/**
	 * @var string $description
	 */
	private $description = "";
	/**
	 * @var PictureModel|null $picture
	 */
	private $picture = NULL;


	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return PictureBlockModel
	 */
	public function setTitle(string $title): PictureBlockModel {
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
	 * @return PictureBlockModel
	 */
	public function setDescription(string $description): PictureBlockModel {
		$this->description = $description;

		return $this;
	}


	/**
	 * @return null|PictureModel
	 */
	public function getPicture() {
		return $this->picture;
	}


	/**
	 * @param null|PictureModel $picture
	 *
	 * @return PictureBlockModel
	 */
	public function setPicture($picture) {
		$this->picture = $picture;

		return $this;
	}
}