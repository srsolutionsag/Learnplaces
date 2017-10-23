<?php

namespace SRAG\Learnplaces\aop\annotation;

/**
 * Class Cacheable
 *
 * @package SRAG\Learnplaces\aop\annotation
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @Annotation
 * @Target({"METHOD"})
 * @Attributes({
 *   @Attribute("region", type = "string"),
 *   @Attribute("key",  type = "string"),
 * })
 */
class Cacheable {

	/**
	 * The cache region which is used to evict a complete region of objects.
	 * For example all books.
	 *
	 * @var string $region
	 * @Required
	 */
	public $region = "";
	/**
	 * The spel expression which is used to compute the object cache key.
	 *
	 * @var string $key
	 * @Required
	 */
	public $key = "";
}