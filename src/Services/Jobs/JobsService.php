<?php

declare(strict_types=1);

namespace App\Services\Jobs;

use App\Entity\Jobs;
use App\Repository\CompanyRepository;
use App\Repository\JobsRepository;
use App\Services\File\FileReaderInterface;
use App\Services\Jobs\JobsServiceInterface;
use App\Validator\JobBulkValidator;
use Psr\Log\LoggerInterface;
use DateTimeImmutable;

class JobsService implements JobsServiceInterface
{
    private FileReaderInterface $fileReader;
    private JobBulkValidator $bulkValidator;
    private LoggerInterface $logger;
    private CompanyRepository $companyRepository;
    private JobsRepository $jobsRepository;

    private int $totalJobs = 0;
    private int $invalidJobs = 0;
    private int $validJobs = 0;
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
        JobBulkValidator $bulkValidator,
        LoggerInterface $logger,
        CompanyRepository $companyRepository,
        JobsRepository $jobsRepository
    ) {
        $this->fileReader = $fileReader;
        $this->bulkValidator = $bulkValidator;
        $this->logger = $logger;
        $this->companyRepository = $companyRepository;
        $this->jobsRepository = $jobsRepository;
    }

    public function saveBulkJobs(): array
    {
        $jobs = $this->fileReader->getData();
        $this->totalJobs = sizeof($jobs['jobs']);
        if (empty($jobs['jobs'])) {
            throw new \Exception('Jobs to read not found or empty');
        }

        foreach ($jobs['jobs'] as $dataJobs) {
            if ($this->bulkValidator->isValid($dataJobs)) {
                $company = $this->companyRepository->find($dataJobs['company_id']);
                
                if (empty($company)) {
                    $this->invalidJobs++;

                    $this->logger->error(
                        "Error",
                        [
                            json_encode("Can't find a company with the id" . $dataJobs['company_id'])
                        ]
                    );
                } else {
                    $this->validJobs++;

                    
                    $job = new Jobs();

                    $job->setName($dataJobs['name']);
                    $job->setDescription($dataJobs['description']);
                    $job->setCompanyId($company);
                    $job->setActive((int) $dataJobs['active']);
                    $job->setPriority((int) $dataJobs['priority']);
                    $job->setCreatedAt(new DateTimeImmutable());

                    $this->jobsRepository->save($job);
                }
                
            } else {
                $this->invalidJobs++;

                $this->logger->error(
                    "Error",
                    [
                        json_encode('Invalid jobs in the file')
                    ]
                );
            }
            
        }
        return [
            "total jobs" => $this->totalJobs,
            "valid jobs" => $this->validJobs,
            "invalid jobs" => $this->invalidJobs
        ];
        
    }
}
