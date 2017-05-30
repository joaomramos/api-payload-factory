<?php

namespace JumiaMarket\ApiPayloadFactory;

use StdClass;

/**
 * Factory definition class
 *
 * @author João Ramos <joao.ramos@jumia.com>
 * @author Sérgio Nogueira <sergio.nogueira@jumia.com>
 * @package JumiaMarket\ApiPayloadFactory
 */
class Definition
{
    /** @var string */
    protected $endPoint;

    /** @var float */
    protected $version;

    /** @var array */
    protected $definition = [];

    /**
     * Definition constructor.
     *
     * @param string $endpoint
     * @param float  $version
     */
    public function __construct($endpoint, $version)
    {
        $this->endPoint = $endpoint;
        $this->version = $version;
    }

    /**
     * Get end point
     *
     * @return string
     */
    public function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * Get version
     *
     * @return float
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the attribute definitions.
     *
     * @param array $definition
     *
     * @return $this
     */
    public function setDefinition(array $definition = [])
    {
        $this->definition = $definition;

        return $this;
    }

    /**
     * Get payload
     *
     * @return StdClass
     */
    public function getPayload()
    {
        return json_decode(json_encode($this->definition));
    }
}
