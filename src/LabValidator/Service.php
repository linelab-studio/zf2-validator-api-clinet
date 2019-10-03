<?php
/**
 * Created by PhpStorm.
 * User: glocj
 * Date: 30.09.2019
 * Time: 12:27
 */

namespace LabValidator;


use TestValid\Exeptation\ConfigException;

class Service
{


    /**
     * Default config
     * @var array
     */
    static $configArray = [
        'apiKey' => null,
        'host' => null
    ];

    public function __construct(array $config = null)
    {
        if(!empty($config['LabValidator']) && is_array($config['LabValidator'])) {
            try{
                $this->setConfig($config['LabValidator']);
            }catch (ConfigException $exception){
                echo 'Error: '. $exception->getMessage();
            }
        }
    }


    public function setConfig($config)
    {
        if(!empty($config['apiKey'])){
            self::$configArray['apiKey'] = $config['apiKey'];
        }
        if(!empty($config['host'])){
            self::$configArray['host'] = $config['host'];
        }
        $this->isValidConfig();

    }

    public function isValidConfig()
    {
        if(empty(self::$configArray['apiKey'])){
            throw new ConfigException('Incorrect configuration apiKey');
        }
        if(empty(self::$configArray['host'])){
            throw new ConfigException('Incorrect configuration host');
        }

    }


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