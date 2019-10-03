<?php
/**
 * Created by PhpStorm.
 * User: glocj
 * Date: 30.09.2019
 * Time: 12:28
 */

namespace LabValidator;


use Zend\Validator\AbstractValidator;

class PhoneValidator  extends AbstractValidator
{

    protected $serviceValidators;

    protected $hostValidator;
    protected $formatValidator;

    const PHONE_NOT_EXISTS = 'notExist';

    protected $messageTemplates = [
        self::PHONE_NOT_EXISTS => "Phone number '%value%' does not exist.",
    ];


    public function __construct(array $config = null)
    {
        if(empty($this->serviceValidators)){
            $this->serviceValidators = new Service($config);
        }
        parent::__construct(null);
    }

    public function isValid($value)
    {
        // TODO: Implement isValid() method.
        $this->setValue((string)$value);

        $isValidByLabValidator = $this->isValidByLabValidator($value);
        if($isValidByLabValidator !== true && $isValidByLabValidator !== null){
            $this->error(self::PHONE_NOT_EXISTS);
            return false;
        }

        return true;

    }


    /**
     * @return Service
     */
    public function getLabValidatorApi()
    {
        if(empty($this->serviceValidators)){
            $this->serviceValidators = new Service();
        }

        return $this->serviceValidators;
    }


    public function isValidByLabValidator($value)
    {
        if($value){
            try {
                $service = $this->getLabValidatorApi();
                $response = $service->getClientPhoneValidator()->checkPhoneValueGet($value);
                return $response->getIsValid();

            }catch (\Exception $exception){
                return null;
            }
        }
        return false;
    }
}