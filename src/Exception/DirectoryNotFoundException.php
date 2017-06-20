<?php

namespace JumiaMarket\ApiPayloadFactory\Exception;

use Exception;

/**
 * Directory not found exception
 *
 * @author João Ramos <joao.ramos@jumia.com>
 * @author Sérgio Nogueira <sergio.nogueira@jumia.com>
 * @package JumiaMarket\ApiPayloadFactory
 */
class DirectoryNotFoundException extends Exception
{
    /**
     * @param string $path
     * @param string $message
     */
    public function __construct($path, $message = null)
    {
        if (! $message) {
            $message = 'The directory ' . $path . ' was not found.';
        }
        parent::__construct($message);
    }
}