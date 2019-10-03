<?php
/**
 * Created by PhpStorm.
 * User: glocj
 * Date: 03.10.2019
 * Time: 10:51
 */

namespace TestValid\Exeptation;

use \Exception;

class ConfigException extends Exception
{

    public function __construct($message = "", $code = 0, $responseHeaders = [], $responseBody = null)
    {

        parent::__construct($message, $code);
        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
    }

}