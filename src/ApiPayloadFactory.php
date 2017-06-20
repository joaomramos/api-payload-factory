<?php

namespace JumiaMarket\ApiPayloadFactory;

use Countable;
use InvalidArgumentException;
use JumiaMarket\ApiPayloadFactory\Exception\DefinitionDuplicatedException;
use JumiaMarket\ApiPayloadFactory\Exception\DefinitionNotFoundException;
use JumiaMarket\ApiPayloadFactory\Exception\DirectoryNotFoundException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * API payload factory
 *
 * @author João Ramos <joao.ramos@jumia.com>
 * @author Sérgio Nogueira <sergio.nogueira@jumia.com>
 * @package JumiaMarket\ApiPayloadFactory
 */
class ApiPayloadFactory implements Countable
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

        if ($this->isEndpointDefined($endpoint, $version)) {
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

        if (! $this->isEndpointDefined($endpoint, $version)) {
            throw new DefinitionNotFoundException($endpoint);
        }

        return  $version ? $this->definitions[$endpoint][$version] : $this->definitions[$endpoint];
    }

    /**
     * Loads factories from a directory
     *
     * @param string $path
     *
     * @return $this
     *
     * @throws DirectoryNotFoundException
     */
    public function loadFactories($path)
    {
        $real = realpath($path);
        if (! $real || ! is_dir($real)) {
            throw new DirectoryNotFoundException($path);
        }
        $this->loadDirectory($real);

        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->definitions);
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

    /**
     * @param string $endpoint
     * @param mixed  $version
     * @return bool
     */
    protected function isEndpointDefined($endpoint, $version = null)
    {
        return $version && isset($this->definitions[$endpoint][$version])
            || (! $version && isset($this->definitions[$endpoint]));
    }

    /**
     * Load all the directory files.
     * $apiPF is going to have instance available.
     *
     * @param string $path
     *
     * @return void
     */
    protected function loadDirectory($path)
    {
        $directory = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($directory);
        $files = new RegexIterator($iterator, '/^[^\.](?:(?!\/\.).)+?\.php$/i');
        $apiPF = $this;
        foreach ($files as $file) {
            require $file->getPathName();
        }
    }
}