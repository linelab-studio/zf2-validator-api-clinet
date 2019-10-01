<?php
/**
 * Created by PhpStorm.
 * User: glocj
 * Date: 30.09.2019
 * Time: 12:27
 */

namespace LabValidator;

use LabValidator\Exception\ConfigException;

class Service
{


    /**
     * Service constructor.
     * @param array|null $config
     */
    public function __construct(array $config = null)
    {
        if($config) {
            try {
                $this->setConfig($config);
            } catch (\LabValidator\Exception\ConfigException $e) {
            }
        }
    }


    public function setConfig($config) {

        if(!empty($config['LabValidator']['apiKey'])){
            self::$configArray['apiKey'] = $config['labValidator']['apiKey'];
        }
        if(!empty($config['LabValidator']['host'])){
            self::$configArray['apiKey'] = $config['labValidator']['host'];
        }
        $this->isValidConfig();
    }

    protected function isValidConfig()
    {
        if (empty(self::$configArray['apiKey'])) {
            throw new \LabValidator\Exception\ConfigException('apiKey');
        }
        if (empty(self::$configArray['host'])) {
            throw new \LabValidator\Exception\ConfigException('host');
        }
    }


    /**
     * Default config
     * @var array
     */
    static $configArray = [
        'apiKey' => null,
        'host' => null
    ];


    /**
     * @return \Service\Api\EmailApi
     */
    public function getClientEmailValidator()
    {

        $config = $this->getConfiguration();
        $apiInstance = new \Service\Api\EmailApi(
            new \GuzzleHttp\Client(['verify' => false]),
            $config
        );

        return $apiInstance;
    }


    /**
     * @return \Service\Api\PhoneApi
     */
    public function getClientPhoneValidator()
    {
        $config = $this->getConfiguration();
        $apiInstance = new \Service\Api\PhoneApi(
            new \GuzzleHttp\Client(['verify' => false]),
            $config
        );

        return $apiInstance;

    }

    /**
     * @return \Service\Configuration
     */
    protected function getConfiguration()
    {

        $config = \Service\Configuration::getDefaultConfiguration()->setApiKey('apiKey', self::$configArray['apiKey'])->setHost(self::$configArray['host']);
        return $config;
    }

}