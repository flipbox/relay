<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Tests\Helpers;

use Flipbox\Relay\Helpers\RelayHelper;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.0
 */
class RelayHelperTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function createResolverTest()
    {
        $closure = RelayHelper::createResolver();
        $this->assertEquals(true, $closure instanceof \Closure);
    }
}