# Validator

Validator Email and Phone - Zend Framework 2.

## Requirements

PHP 5.5 and later

## Installation & Usage

### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```json
{
  "require": {
    "linelab-studio/zf2-validator-api-client": "1.0.1"
  }
}
```

Then run `composer install`


### Usage 

Add configuration data. The configuration can be in the module configuration or in the project autoload files.

```php 
'LabValidator' => [
    'apiKey' => 'exampleApiKey',
    'host' => 'https://localhost/validator/api'
],
```

Creation of the ZF2 Validator class.

Two validators are available:
* EmailValidator (namespace LabValidator\EmailValidator)
* PhoneValidator (namespace LabValidator\PhoneValidator)

```
<?php
namespace App\Validator;

class EmailAddressValidator extends LabValidator\EmailValidator
{
    public function __construct(array $config = null)
    {
        parent::__construct($config);
    }
}
?>
```

Adding a validator to the field in the form

```php 
public function validatorAction()
{
    $form = new Form();
    $form
       ->add([
            'name' => 'email',
            'type' => 'email',
            'attributes' => [
                'required' => true,
            ],
            'options' => [
                'label' => 'Email',
                'validators' => [
                    $this->serviceLocator->get(EmailAddressValidator::class)
                ]
            ]
        ]);
}
```

## Author

studio@linelab.pl

