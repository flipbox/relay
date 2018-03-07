<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Builder;

use Flipbox\Relay\Salesforce\Runner;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Logger\AutoLoggerTrait;
use Flipbox\Skeleton\Object\AbstractObject;
use Psr\Log\InvalidArgumentException;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 3.0.0
 */
class RelayBuilder extends AbstractObject implements RelayBuilderInterface
{
    use AutoLoggerTrait;

    /**
     * @var array[]
     */
    private $middleware = [];

    /**
     * @inheritdoc
     */
    public function addAfter(string $key, array $middleware, string $afterKey = null)
    {
        if ($afterKey === null || array_key_exists($key, $this->middleware)) {
            $this->middleware[$key] = $middleware;
            return $this;
        }

        if (false === ($newOrder = ArrayHelper::insertAfter($this->middleware, $afterKey, $key, $middleware))) {
            $this->middleware[$key] = $middleware;
            return $this;
        }

        $this->middleware = $newOrder;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addBefore(string $key, array $middleware, string $beforeKey = null)
    {
        if (array_key_exists($key, $this->middleware)) {
            $this->middleware[$key] = $middleware;
            return $this;
        }

        if ($beforeKey === null) {
            $this->middleware = [$key => $middleware] + $this->middleware;
            return $this;
        }

        if (false === ($newOrder = ArrayHelper::insertBefore($this->middleware, $beforeKey, $key, $middleware))) {
            $this->middleware[$key] = $middleware;
            return $this;
        }

        $this->middleware = $newOrder;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function merge(string $key, array $middleware)
    {
        if (array_key_exists($key, $this->middleware)) {
            $this->middleware[$key] = $middleware;
            return $this;
        }

        $this->middleware[$key] = array_merge(
            $this->middleware[$key],
            $middleware
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function build(): callable
    {
        try {
            return new Runner(
                $this->middleware
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param \Exception $exception
     * @throws InvalidArgumentException
     */
    protected function handleException(\Exception $exception)
    {
        $this->error(
            "Exception building relay middleware: {exception}",
            [
                'exception' => json_encode($exception)
            ]
        );

        throw new InvalidArgumentException(
            $exception->getMessage(),
            $exception->getCode()
        );
    }
}
