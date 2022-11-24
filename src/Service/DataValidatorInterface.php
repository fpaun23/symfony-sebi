<?php
declare(strict_types=1);

namespace App\Service;

interface DataValidatorInterface
{
    public function contactValidate(array $validator):bool;
    public function err():string;
}
