<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\BlockDtoMappingAware;

/**
 * Class BlockModel
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
abstract class BlockModel {

	use BlockDtoMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;
	/**
	 * @var int $sequence
	 */
	private $sequence = PHP_INT_MAX;
	/**
	 * @var string $visibility
	 */
	private $visibility = "ALWAYS";
	/**
	 * @var BlockConstraint|null $constraint
	 */
	private $constraint = NULL;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return BlockModel
	 */
	public function setId(int $id): BlockModel {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getSequence(): int {
		return $this->sequence;
	}


	/**
	 * @param int $sequence
	 *
	 * @return BlockModel
	 */
	public function setSequence(int $sequence): BlockModel {
		$this->sequence = $sequence;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getVisibility(): string {
		return $this->visibility;
	}


	/**
	 * @param string $visibility
	 *
	 * @return BlockModel
	 */
	public function setVisibility(string $visibility): BlockModel {
		$this->visibility = $visibility;

		return $this;
	}


	/**
	 * @return null|BlockConstraint
	 */
	public function getConstraint() {
		return $this->constraint;
	}


	/**
	 * @param null|BlockConstraint $constraint
	 *
	 * @return BlockModel
	 */
	public function setConstraint($constraint) {
		$this->constraint = $constraint;

		return $this;
	}
}