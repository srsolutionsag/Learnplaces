<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

/**
 * Class VideoModel
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class VideoModel {

	/**
	 * @var string $videoPath
	 */
	private $videoPath = '';
	/**
	 * @var string $coverPath
	 */
	private $coverPath = '';


	/**
	 * @return string
	 */
	public function getVideoPath(): string {
		return $this->videoPath;
	}


	/**
	 * @param string $videoPath
	 *
	 * @return VideoModel
	 */
	public function setVideoPath(string $videoPath): VideoModel {
		$this->videoPath = $videoPath;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getCoverPath(): string {
		return $this->coverPath;
	}


	/**
	 * @param string $coverPath
	 *
	 * @return VideoModel
	 */
	public function setCoverPath(string $coverPath): VideoModel {
		$this->coverPath = $coverPath;

		return $this;
	}
}