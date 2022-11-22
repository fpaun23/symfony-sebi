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
    /**
     * check if the data is valid
     *
     * @param  mixed $validator
     * @return bool
     */
    public function contactValidate(array $validator):bool
    {
        
        
        if ((strlen($validator[0]) < ConstantContact::NAME[0]
        || strlen($validator[0]) > ConstantContact::NAME[1]
        || !preg_match("/^[a-zA-Z]+$/", $validator[0]))) {
            $this->errorMesage = $this->errorMesage . ConstantContact::MSGNAME  ;
        }
        if (!filter_var($validator[2], FILTER_VALIDATE_EMAIL)) {
            $this->errorMesage = $this->errorMesage . ConstantContact::MSGMAIL ;
        }
        if ((strlen($validator[1]) < ConstantContact::DESCRIPTION[0]
        || strlen($validator[1]) > ConstantContact::DESCRIPTION[1])) {
            $this->errorMesage = $this->errorMesage . ConstantContact::MSGDESC ;
        }

        if (empty($this->errorMesage)) {
            return true;
        } return false;
    }
    /**
     * Displays the errors
     *
     * @return string
     */
    public function err(): string
    {
        return $this->errorMesage;
    }
}
