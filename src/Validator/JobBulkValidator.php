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

        foreach ($jobs as $job) {
            foreach (self::KEY as $key) {
                if (!array_key_exists($key, $job)) {
                    return false;
                }
            }
        }

        return true;
    }
}
