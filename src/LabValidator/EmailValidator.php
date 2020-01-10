<?php
/**
 * Created by PhpStorm.
 * User: glocj
 * Date: 30.09.2019
 * Time: 12:27
 */
namespace LabValidator;



use Zend\Validator\AbstractValidator;
use Zend\Validator\Hostname;

class EmailValidator  extends AbstractValidator
{

    protected $serviceValidators;

    protected $hostValidator;
    protected $formatValidator;

    const INVALID_FORMAT = 'invalidFormat';
    const ADDRESS_NOT_EXISTS = 'notExist';

    protected $messageTemplates = [
        self::INVALID_FORMAT => "'%value%' is not a valid email address.",
        self::ADDRESS_NOT_EXISTS => "Email '%value%' does not exist.",
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

        if($this->getFormatValidator()->isValid($value) === false){
            $this->error(self::INVALID_FORMAT);
            return false;
        }

        if($this->getHostValidator()->isValid($value) === false){
            $this->error(self::ADDRESS_NOT_EXISTS);
            return false;
        }

        $isValidByLabValidator = $this->isValidByLabValidator($value);

        if($isValidByLabValidator !== true && $isValidByLabValidator !== null){
            $this->error(self::ADDRESS_NOT_EXISTS);
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


    /**
     * @return \Zend\Validator\EmailAddress
     */
    public function getHostValidator()
    {
        if(!$this->hostValidator) {
            $this->hostValidator = new \Zend\Validator\EmailAddress([
                'allow'=> Hostname::ALLOW_DNS,
                'useMxCheck'=> true
            ]);
        }
        return $this->hostValidator;

    }

    /**
     * @return \Zend\Validator\EmailAddress
     */
    public function getFormatValidator()
    {
        if(!$this->formatValidator){
            $this->formatValidator = new \Zend\Validator\EmailAddress();
        }
        return $this->formatValidator;
    }

    public function isValidByLabValidator($value)
    {
        if($value){
            try {
                $service = $this->getLabValidatorApi();
                $response = $service->getClientEmailValidator()->checkEmailGet($value);
                return $response->getIsValid();

            }catch (\Exception $exception){
                return null;
            }
        }
        return false;
    }
}