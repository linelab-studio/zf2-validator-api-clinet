<?php
/**
 * Created by PhpStorm.
 * User: glocj
 * Date: 30.09.2019
 * Time: 14:10
 */

namespace LabValidator\Exception;


use Throwable;

class ConfigException extends \Exception
{
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        $message = 'Incorrect configuration '. $message;
        parent::__construct($message, $code, $previous);
    }

}