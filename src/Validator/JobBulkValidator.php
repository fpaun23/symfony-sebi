<?php

declare(strict_types=1);

namespace App\Validator;
use TheSeer\Tokenizer\Exception;

class JobBulkValidator implements JobBulkValidatorInterface
{
    private const KEY = ['name' , 'description' , 'active' , 'priority', 'company_id'];

    public function isValid(array $jobs): bool
    {
        if (empty($jobs)) {
            throw new \Exception('Empty array of jobs');
        } else {
            foreach (self::KEY as $key) {
                if (array_key_exists($key, $jobs)) {
                    return false;
                }
            }
        }
        return true;
    }
}
