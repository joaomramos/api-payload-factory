<?php

namespace JumiaMarket\ApiPayloadFactory;

/**
 * Factory definition class
 *
 * @package JumiaMarket\ApiPayloadFactory
 * @author  Sérgio Nogueira <sergio.nogueira@jumia.com>
 */
class Definition
{
    /** @var string */
    protected $endPoint;

    /** @var float */
    protected $version;

    /** @var array */
    protected $definitions = [];

    /**
     * Definition constructor.
     *
     * @param string $endpoint
     * @param bool   $version
     */
    public function __construct($endpoint, $version)
    {
        assert(is_string($endpoint));
        assert(is_float($version));

        $this->endPoint = $endpoint;
        $this->version = $version;
    }

    /**
     * Set the attribute definitions.
     *
     * @param array $definitions The attribute definitions.
     *
     * @return \JumiaMarket\ApiPayloadFactory\Definition
     */
    public function setDefinitions(array $definitions = [])
    {
        $this->definitions = array_merge($this->definitions, $definitions);

        return $this;
    }
}
