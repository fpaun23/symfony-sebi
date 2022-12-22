<?php

declare(strict_types=1);

namespace App\Validator;

use TheSeer\Tokenizer\Exception;

class JobBulkValidator implements JobBulkValidatorInterface
{
    private const KEY = ['name' , 'company_id' , 'description' , 'active', 'priority'];

    public function isValid(array $jobs): bool
    {
        if (empty($jobs)) {
            throw new \Exception('Empty array of jobs');
        }

        foreach (self::KEY as $key) {
            if (!array_key_exists($key, $jobs)) {
                return false;
            }
        }

        if (!is_numeric($jobs['company_id']) || $jobs['company_id'] < 1) {
            return false;
        }

        if (!in_array($jobs['active'], [0, 1]) || !in_array($jobs['priority'], [0, 1])) {
            return false;
        }

        if (empty(trim($jobs['name'])) || empty(trim($jobs['description']))) {
            return false;
        }


        return true;
    }
}
