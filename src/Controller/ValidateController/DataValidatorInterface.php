<?php
declare(strict_types=1);

namespace App\Controller\ValidateController;

use Symfony\Component\Validator\Mapping\ClassMetadata;

interface DataValidatorInterface
{
    public function contactValidate(ClassMetadata $validator);

}
