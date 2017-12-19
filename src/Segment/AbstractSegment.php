<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay
 */

namespace Flipbox\Relay\Segments;

use Flipbox\Relay\Helpers\RelayHelper;
use Flipbox\Relay\Segments\Exceptions\InvalidResponseException;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Helpers\ObjectHelper;
use Flipbox\Skeleton\Logger\AutoLoggerTrait;
use Flipbox\Skeleton\Object\AbstractObject;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Relay\Runner;
use Zend\Diactoros\Request;
use Zend\Diactoros\Response;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 2.0.1
 */
abstract class AbstractSegment extends AbstractObject implements SegmentInterface
{

    use AutoLoggerTrait;

    /**
     * @var array
     */
    protected $segments;

    /**
     * @return array
     */
    protected function defaultSegments(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->segments === null) {
            $this->segments = $this->defaultSegments();
        }

        parent::init();
    }

    /**
     * @param string $key
     * @param $segment
     * @param string|null $afterKey
     * @return $this
     */
    public function addAfter(string $key, $segment, string $afterKey = null)
    {
        if ($afterKey === null) {
            $this->segments[$key] = $segment;
            return $this;
        }

        if (false === ($segments = ArrayHelper::insertAfter($this->segments, $afterKey, $key, $segment))) {
            $this->segments[$key] = $segment;
            return $this;
        }

        $this->segments = $segments;
        return $this;
    }

    /**
     * @param string $key
     * @param $segment
     * @param string|null $beforeKey
     * @return $this
     */
    public function addBefore(string $key, $segment, string $beforeKey = null)
    {
        if ($beforeKey === null) {
            $this->segments = [$key => $segment] + $this->segments;
            return $this;
        }

        if (false === ($segments = ArrayHelper::insertBefore($this->segments, $beforeKey, $key, $segment))) {
            $this->segments[$key] = $segment;
            return $this;
        }

        $this->segments = $segments;
        return $this;
    }


    /**
     * @inheritdoc
     */
    public function run(
        RequestInterface $request = null,
        ResponseInterface $response = null
    ): ResponseInterface {
        // Reconfigure?
        if (!empty($config)) {
            ObjectHelper::configure($this, $config);
        }

        try {
            // Relay runner
            $runner = new Runner(
                $this->getSegments(),
                RelayHelper::createResolver()
            );
            return $runner(
                $this->resolveRequest($request),
                $this->resolveResponse($response)
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param null $request
     * @return RequestInterface
     */
    protected function resolveRequest($request = null): RequestInterface
    {
        if($request instanceof RequestInterface) {
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
        if($response instanceof ResponseInterface) {
            return $response;
        }

        return new Response();
    }

    /**
     * @return array
     */
    protected function getSegments()
    {
        return $this->segments;
    }


    /**
     * @param \Exception $exception
     * @throws InvalidResponseException
     */
    protected function handleException(\Exception $exception)
    {
        $this->error(
            "Exception running relay segments: {exception}",
            [
                'exception' => json_encode($exception)
            ]
        );

        throw new InvalidResponseException(
            $exception->getMessage(),
            $exception->getCode()
        );
    }

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request = null,
        ResponseInterface $response = null
    ): ResponseInterface {
        return $this->run($request, $response);
    }
}
