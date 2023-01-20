<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Runner;

use Flipbox\Skeleton\Helpers\ObjectHelper;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\InvalidArgumentException;
use Relay\MiddlewareInterface;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 3.0.0
 */
class Runner
{
    /**
     * @var (callable|MiddlewareInterface)[]
     */
    private $middleware = [];

    /**
     * @param array $queue
     */
    public function __construct(array $queue)
    {
        $this->middleware = $queue;
    }

    /**
     *
     * Calls the next middleware in the queue.
     *
     * @param RequestInterface|null $request The incoming request.
     * @param ResponseInterface|null $response The outgoing response.
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request = null, ResponseInterface $response = null)
    {
        $middleware = array_shift($this->middleware);
        $middleware = $this->resolve($middleware);
        return $middleware(
            $this->resolveRequest($request),
            $this->resolveResponse($response),
            $this
        );
    }

    /**
     * Converts a queue middleware to a callable.
     *
     * @param string|array|callable|MiddlewareInterface $middleware
     * @return callable
     */
    protected function resolve($middleware): callable
    {
        if (null === $middleware) {
            return function (RequestInterface $request, ResponseInterface $response, callable $next) {
                return $response;
            };
        }

        return $this->resolveMiddleware($middleware);
    }

    /**
     * @param $middleware
     * @return callable|\Flipbox\Skeleton\Object\ObjectInterface|MiddlewareInterface
     */
    private function resolveMiddleware($middleware)
    {
        if ($this->isMiddleware($middleware)) {
            return $middleware;
        }

        try {
            /** @var callable|MiddlewareInterface $middleware */
            $middleware = ObjectHelper::create(
                $middleware
            );
        } catch (\Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        if (!$this->isMiddleware($middleware)) {
            throw new InvalidArgumentException("Unable to resolve middleware");
        }

        return $middleware;
    }

    /**
     * @param $middleware
     * @return bool
     */
    protected function isMiddleware($middleware): bool
    {
        return is_callable($middleware) || $middleware instanceof MiddlewareInterface;
    }

    /**
     * @param null $request
     * @return RequestInterface
     */
    protected function resolveRequest($request = null): RequestInterface
    {
        if ($request instanceof RequestInterface) {
            return $request;
        }

        return new Request();
    }

    /**
     * @param null $response
     * @return ResponseInterface
     */
    protected function resolveResponse($response = null): ResponseInterface
    {
        if ($response instanceof ResponseInterface) {
            return $response;
        }

        return new Response();
    }
}
