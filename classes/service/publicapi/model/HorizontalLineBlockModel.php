<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\HorizontalLineBlockDtoMappingAware;

/**
 * Class HorizontalLineBlock
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class HorizontalLineBlockModel extends BlockModel {

	use HorizontalLineBlockDtoMappingAware;
}