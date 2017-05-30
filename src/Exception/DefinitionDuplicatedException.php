<?php

namespace JumiaMarket\ApiPayloadFactory\Exception;

use Exception;

/**
 * API payload factory
 *
 * @author João Ramos <joao.ramos@jumia.com>
 * @author Sérgio Nogueira <sergio.nogueira@jumia.com>
 * @package JumiaMarket\ApiPayloadFactory
 */
class DefinitionDuplicatedException extends Exception
{
    /**
     * @param string $endpoint
     * @param string $message
     * @return void
     */
    public function __construct($endpoint, $message = null)
    {
        if (! $message) {
            $message = 'The endpoint definition for ' . $endpoint . ' is already defined.';
        }
        parent::__construct($message);
    }
}