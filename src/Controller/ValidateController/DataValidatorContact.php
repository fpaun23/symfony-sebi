<?php

declare(strict_types=1);

namespace App\Controller\ValidateController;

use App\ConstantContact;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\ValidateController\DataValidatorInterface;

class DataValidatorContact implements DataValidatorInterface
{
    private $name;
    private $description;
    private $email;
    public function contactValidate(ClassMetadata $validator)
    {
        $validator->addPropertyConstraint('name', new Assert\NotBlank());
        $validator->addPropertyConstraint('name', new Assert\Length([
            'min' => ConstantContact::NAME[0],
            'max' => ConstantContact::NAME[1],
            'minMessage' => 'Your name must be at least {{ limit }} characters long',
            'maxMessage' => 'Your  name cannot be longer than {{ limit }} characters'
        ]));
        $validator->addPropertyConstraint('description', new Assert\NotBlank());
        $validator->addPropertyConstraint('description', new Assert\Length([
            'min' => ConstantContact::DESCRIPTION[0],
            'max' => ConstantContact::DESCRIPTION[1],
            'minMessage' => 'Your description must be at least {{ limit }} characters long',
            'maxMessage' => 'Your description  cannot be longer than {{ limit }} characters'
        ]));
        $validator->addPropertyConstraint('email', new Assert\NotBlank());
        $validator->addPropertyConstraint('email', new Assert\Email([
            'message' => 'The email "{{ value }}" is not a valid email.'
        ]));
    }
}
