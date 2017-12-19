<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\FeedbackBlockDtoMappingAware;

/**
 * Class FeedbackBlock
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class FeedbackBlockModel extends BlockModel {

	use FeedbackBlockDtoMappingAware;

}