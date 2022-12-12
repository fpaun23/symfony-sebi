<?php

declare(strict_types=1);

namespace App\Validator;

class JobValidator
{
    public function nameIsValid(string $name): bool
    {
        if ($name == null) {
            throw new \InvalidArgumentException('You must enter a job name!');
        }

        if (strlen($name) <= 2) {
            throw new \InvalidArgumentException('Job length must be > 2');
        }


        return true;
    }

    public function idIsValid(int $id): bool
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException("Id must be > 0");
        }
        
        return true;
    }
}
