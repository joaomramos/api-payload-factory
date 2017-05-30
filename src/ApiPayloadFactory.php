<?php

namespace JumiaMarket\ApiPayloadFactory;

use InvalidArgumentException;
use JumiaMarket\ApiPayloadFactory\Exception\DefinitionDuplicatedException;

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
    protected static $definitions = [];

    /**
     * @param string         $endpoint
     * @param string|integer $version
     *
     * @return Definition
     * @throws DefinitionDuplicatedException
     */
    public static function define($endpoint, $version = null)
    {
        $version = (string) $version;

        if (! is_string($endpoint)) {
            throw new InvalidArgumentException('Endpoint must be a string.');
        }

        if (($version && isset(static::$definitions[$endpoint][$version])
            || (! $version && isset(static::$definitions[$endpoint])))) {
                throw new DefinitionDuplicatedException($endpoint);
        }

        return static::$definitions[$endpoint][$version] = new Definition($endpoint, $version);
    }
}