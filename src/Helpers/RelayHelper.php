<?php

/**
 * Relay Helper
 *
 * @package    Relay
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Relay/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Relay
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Relay\Helpers;

use Flipbox\Skeleton\Helpers\ObjectHelper;
use Relay\MiddlewareInterface;

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
                $config, 'Relay\MiddlewareInterface'
            );

        };

    }

}
