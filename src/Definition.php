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

    /**
     * __call magic method to handle "set" or "get"
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $operation = strtolower(substr($name, 0, 3));
        $property = $this->convertFromCamelCase(substr($name, 3));

        switch ($operation) {
            case 'set':
                $result = $this->setDefinitionValue($property, current($arguments));
                break;
            case 'get':
                $result = $this->getDefinitionValue($property);
                break;
            default:
                $result = null;
        }

        return $result;
    }

    /**
     * Convert from camel case
     *
     * @param string $value
     *
     * @return string
     */
    protected function convertFromCamelCase($value)
    {
        return strtolower(
            preg_replace(
                ["/([A-Z]+)/", "/_([A-Z]+)([A-Z][a-z])/"],
                ["_$1", "_$1_$2"],
                lcfirst($value)
            )
        );
    }

    /**
     * Set definition value
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    protected function setDefinitionValue($key, $value)
    {
        $this->definition[$key] = $value;

        return $this;
    }

    /**
     * Get definition value
     *
     * @param string $key
     *
     * @return mixed|null
     */
    protected function getDefinitionValue($key)
    {
        return isset($this->definition[$key]) ? $this->definition[$key] : null;
    }
}
