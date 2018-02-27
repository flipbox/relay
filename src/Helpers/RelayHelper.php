<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Helpers;

use Flipbox\Skeleton\Helpers\ObjectHelper;
use Flipbox\Skeleton\Exceptions\InvalidConfigurationException;
use Relay\MiddlewareInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
class RelayHelper
{
    /**
     * @return \Closure|MiddlewareInterface
     */
    public static function createResolver()
    {
        return function ($config) {
            if (static::isValidMiddleware($config)) {
                return $config;
            }

            $config = ObjectHelper::create(
                $config
            );

            if (!static::isValidMiddleware($config)) {
                throw new InvalidConfigurationException("Unable to resolve middleware");
            }

            return $config;
        };
    }

    /**
     * @param $middleware
     * @return bool
     */
    public static function isValidMiddleware($middleware): bool
    {
        return is_callable($middleware) || $middleware instanceof MiddlewareInterface;
    }
}
