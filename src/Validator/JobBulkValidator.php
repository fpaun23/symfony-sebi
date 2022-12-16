<?php

declare(strict_types=1);

namespace App\Validator;

class JobBulkValidator
{
    public function validate(array $jobs): bool
    {
        if (empty($jobs[0])) {
            throw new \InvalidArgumentException('You must enter a job name!');
        }

        if (strlen($jobs[0]) <= 2) {
            throw new \InvalidArgumentException('Job length must be > 2');
        }

        if (empty($jobs[1])) {
            throw new \InvalidArgumentException('You must enter a company id!');
        }

        if (empty($jobs[2])) {
            throw new \InvalidArgumentException('You must enter a description !');
        }

        if (strlen($jobs[2]) <= 2) {
            throw new \InvalidArgumentException('Description length must be > 2');
        }

        if ($jobs[3] != 1 && $jobs[3] != 0 ) {
            throw new \InvalidArgumentException('Active must be 1 or 0!');
        }

        
        if ($jobs[4] != 1 && $jobs[4] != 0 ) {
            throw new \InvalidArgumentException('Priority must be 1 or 0!');
        }
        


        return true;
    }

}
