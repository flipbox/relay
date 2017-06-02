<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Segments;

use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.1
 */
interface SegmentInterface
{
    /**
     * @param array $config
     * @return ResponseInterface
     */
    public function run(array $config = []): ResponseInterface;

    /**
     * @param array $config
     * @return ResponseInterface
     */
    public function __invoke(array $config = []): ResponseInterface;
}
