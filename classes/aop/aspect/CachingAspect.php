<?php

namespace SRAG\Learnplaces\aop\aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;
use InvalidArgumentException;
use Psr\SimpleCache\CacheInterface;
use SRAG\Learnplaces\aop\annotation\Cacheable;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class CachingAspect
 *
 * @package SRAG\Learnplaces\aop\annotation
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CachingAspect implements Aspect {

	/**
	 * @var CacheInterface $cache
	 */
	private $cache;


	/**
	 * CachingAspect constructor.
	 *
	 * @param CacheInterface $cache
	 */
	public function __construct(CacheInterface $cache) { $this->cache = $cache; }

	/**
	 * This advice intercepts the execution of cacheable methods
	 *
	 * The logic is pretty simple: we look for the value in the cache and if we have a cache miss
	 * we then invoke original method and store its result in the cache.
	 *
	 * @param MethodInvocation $invocation Invocation
	 *
	 * @Around("@execution(ObjectCacher\Annotation\Cacheable)")
	 *
	 * @return mixed The result of the point cut method.
	 */
	public function aroundCacheable(MethodInvocation $invocation)
	{
		$spel = new ExpressionLanguage();

		/**
		 * @var Cacheable $cacheableAnotation
		 */
		$cacheableAnotation = $invocation->getMethod()->getAnnotation(Cacheable::class);
		if($cacheableAnotation instanceof Cacheable)
		{
			$cacheKey = $cacheableAnotation->region;
			$cacheKey .= '.';
			$argumentMap = [];
			$parameterMap = $invocation->getMethod()->getParameters();

			foreach ($invocation->getArguments() as $key => $argumentValue) {
				$argumentMap[$parameterMap[$key]->getName()] = $argumentValue;
			}

			$cacheKey .= $spel->evaluate($cacheableAnotation->key, $argumentMap);
			$result = $this->cache->get($cacheKey);
			if (is_null($result)) {
				$result = $invocation->proceed();
				$this->cache->set($cacheKey, $result);
			}

			return $result;
		}

		throw new InvalidArgumentException('Unable to cache object.');

	}
}