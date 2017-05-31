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

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        // Log
        $this->debug(
            sprintf(
                "Begin '%s' Middleware",
                get_class($this)
            )
        );
    }

    /**
     * @param ResponseInterface $response
     * @return bool
     */
    protected function isResponseSuccessful(ResponseInterface $response)
    {
        if (in_array($response->getStatusCode(), [200, 201, 204])) {
            return true;
        }

        $this->getLogger()->warning(
            "API request was not successful",
            [
                'code' => $response->getStatusCode(),
                'reason' => $response->getReasonPhrase()
            ]
        );

        return false;
    }
}
