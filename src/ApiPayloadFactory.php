<?php

namespace JumiaMarket\ApiPayloadFactory;

use InvalidArgumentException;
use JumiaMarket\ApiPayloadFactory\Exception\DefinitionDuplicatedException;
use JumiaMarket\ApiPayloadFactory\Exception\DefinitionNotFoundException;

/**
 * API payload factory
 *
 * @author João Ramos <joao.ramos@jumia.com>
 * @author Sérgio Nogueira <sergio.nogueira@jumia.com>
 * @package JumiaMarket\ApiPayloadFactory
 */
class ApiPayloadFactory
{
    /**
     * @var \JumiaMarket\ApiPayloadFactory\Definition[]
     */
    protected $definitions = [];

    /**
     * @param string $endpoint
     * @param mixed  $version
     *
     * @return Definition
     * @throws DefinitionDuplicatedException
     */
    public function define($endpoint, $version = null)
    {
        $this->checkEndpoint($endpoint)
             ->handleVersion($version);

        if (($version && isset($this->definitions[$endpoint][$version])
            || (! $version && isset($this->definitions[$endpoint])))) {
                throw new DefinitionDuplicatedException($endpoint);
        }

        return $this->definitions[$endpoint][$version] = new Definition($endpoint, $version);
    }

    /**
     * Fetches a defined Definition
     *
     * @param string $endpoint
     * @param mixed  $version
     *
     * @return Definition
     * @throws DefinitionNotFoundException
     */
    public function create($endpoint, $version = null)
    {
        $this->checkEndpoint($endpoint)
             ->handleVersion($version);

        if (! isset($this->definitions[$endpoint])
            || ($version && ! isset($this->definitions[$endpoint][$version]))) {
            throw new DefinitionNotFoundException($endpoint);
        }

        return  $version ? $this->definitions[$endpoint][$version] : $this->definitions[$endpoint];
    }

    /**
     * Not possible to have floating points as array keys.
     * Solution, cast to string.
     *
     * @param mixed $version
     * @return $this
     */
    protected function handleVersion(&$version)
    {
        $version = (string) $version;
        return $this;
    }

    /**
     * @param mixed $endpoint
     *
     * @return $this
     * @throws InvalidArgumentException If endpoint is not a valid string.
     */
    protected function checkEndpoint($endpoint)
    {
        if (! is_string($endpoint)) {
            throw new InvalidArgumentException('Endpoint must be a string.');
        }
        return $this;
    }
}