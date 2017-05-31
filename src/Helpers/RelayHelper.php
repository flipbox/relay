<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Helpers;

use Flipbox\Skeleton\Helpers\ObjectHelper;
use Relay\MiddlewareInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
class RelayHelper
{

    /**
     * @return \Closure
     */
    public static function createResolver()
    {

        return function ($config) {

            if ($config instanceof MiddlewareInterface) {

                return $config;

            }

            return ObjectHelper::create(
                $config, MiddlewareInterface::class
            );

        };

    }

}
