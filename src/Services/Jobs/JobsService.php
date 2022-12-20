<?php

declare(strict_types=1);

namespace App\Services\Jobs;

use App\Services\File\FileReaderInterface;
use App\Services\Jobs\JobsServiceInterface;
use App\Validator\JobBulkValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JobsService implements JobsServiceInterface
{
    private FileReaderInterface $fileReader;
    private JobBulkValidator $bulkValidator;

    /**
     * __construct
     *
     * @param mixed $fileReader
     * @param mixed $bulkValidator
     *
     * @return void
     */
    public function __construct(
        FileReaderInterface $fileReader,
        JobBulkValidator $bulkValidator
    ) {
        $this->fileReader = $fileReader;
        $this->bulkValidator = $bulkValidator;
    }

    public function saveBulkJobs(): bool
    {
        $jobs = $this->fileReader->getData();
        $valid = $this->bulkValidator->isValid($jobs);
        var_dump($valid);
        die;

        return true;
    }
}
