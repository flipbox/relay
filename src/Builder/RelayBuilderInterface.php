<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Builder;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 3.0.0
 */
interface RelayBuilderInterface
{
    /**
     * @return callable
     */
    public function build(): callable;

    /**
     * @param string $key
     * @param $middleware
     * @param string|null $afterKey
     * @return static
     */
    public function addAfter(string $key, array $middleware, string $afterKey = null);

    /**
     * @param string $key
     * @param $middleware
     * @param string|null $afterKey
     * @return static
     */
    public function addBefore(string $key, array $middleware, string $afterKey = null);

    /**
     * @param string $key
     * @param $middleware
     * @return static
     */
    public function merge(string $key, array $middleware);
}
