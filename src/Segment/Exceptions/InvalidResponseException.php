<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Segments\Exceptions;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.1
 */
class InvalidResponseException extends \Exception
{
    /**
     * @var int
     */
    protected $code = 500;

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Invalid Response";
    }
}
