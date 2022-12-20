<?php

declare(strict_types=1);

namespace App\Validator;

interface JobBulkValidatorInterface
{
    public function isValid(array $job): bool;
}
