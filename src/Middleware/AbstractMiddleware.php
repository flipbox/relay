<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Middleware;

use Flipbox\Skeleton\Logger\AutoLoggerTrait;
use Flipbox\Skeleton\Object\AbstractObject;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Relay\MiddlewareInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
abstract class AbstractMiddleware extends AbstractObject implements MiddlewareInterface
{
    use AutoLoggerTrait;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return ResponseInterface|void
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        // Log
        $this->debug(
            sprintf(
                "Begin '%s' Middleware",
                get_class($this)
            )
        );
    }
}
