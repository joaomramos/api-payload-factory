<?php

namespace JumiaMarket\ApiPayloadFactory\Exception;

use Exception;

/**
 * Definition not found exception
 *
 * @author João Ramos <joao.ramos@jumia.com>
 * @author Sérgio Nogueira <sergio.nogueira@jumia.com>
 * @package JumiaMarket\ApiPayloadFactory
 */
class DefinitionNotFoundException extends Exception
{
    /**
     * @param string $endpoint
     * @param string $message
     */
    public function __construct($endpoint, $message = null)
    {
        if (! $message) {
            $message = 'The endpoint definition for ' . $endpoint . ' is not defined.';
        }
        parent::__construct($message);
    }
}