<?php

declare(strict_types=1);

namespace App\Controller\ValidateController;

use App\ConstantContact;
use App\Controller\ContactController;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ValidateController\DataValidatorInterface;

class DataValidatorContact implements DataValidatorInterface
{
    private $errorMesage = "";
    public function contactValidate(array $validator):bool
    {
        
        
        if ((strlen($validator[0]) < ConstantContact::NAME[0]
        || strlen($validator[0]) > ConstantContact::NAME[1]
        || !preg_match("/^[a-zA-Z]+$/", $validator[0]))) {
            $this->errorMesage =  ConstantContact::MSGNAME;
        }
        if (!filter_var($validator[1], FILTER_VALIDATE_EMAIL)) {
            $this->errorMesage =  ConstantContact::MSGMAIL;
        }
        if ((strlen($validator[2]) < ConstantContact::DESCRIPTION[0]
        || strlen($validator[2]) > ConstantContact::DESCRIPTION[1])) {
            $this->errorMesage =  ConstantContact::MSGDESC;
        }

        if (empty($this->errorMesage)) {
            return true;
        } return false;
    }
    public function err(): string
    {
        return $this->errorMesage;
    }
}
