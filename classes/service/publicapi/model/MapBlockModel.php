<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\MapBlockDtoMappingAware;

/**
 * Class MapBlock
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class MapBlockModel extends BlockModel{
	use MapBlockDtoMappingAware;
}