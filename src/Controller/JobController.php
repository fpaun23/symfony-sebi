<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Jobs;
use App\Repository\CompanyRepository;
use App\Repository\JobsRepository;
use App\Service\FileReaderTXT;
use App\Validator\JobValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTimeImmutable;

/**
 * new class for company controller
 */
class JobController extends AbstractController
{

    private JobsRepository $_jobsRepository;
    private JobValidator $_jobValidator;
    private CompanyRepository $_companyRepository;
    private FileReaderTXT $_fileReader;
   
    /**
     * __construct
     *
     * @param mixed $jobsRepository 
     * @param mixed $jobValidator 
     * @param mixed $companyRepository 
     * 
     * @return void
     */
    public function __construct(
        JobsRepository $jobsRepository,
        JobValidator $jobValidator,
        CompanyRepository $companyRepository,
        FileReaderTXT $fileReader
    ) {
        $this->_jobsRepository = $jobsRepository;
        $this->_jobValidator = $jobValidator;
        $this->_companyRepository = $companyRepository;
        $this->_fileReader = $fileReader;
    }
        
    /**
     * Add job
     *
     * @param mixed $request 
     * 
     * @return Response
     */
    public function addJob(Request $request): Response
    {
        $active = 0;
        $priority = 0;
        try {
            $name = $request->get('name');
            $this->_jobValidator->nameIsValid($name);
            $companyId = (int) $request->get('company_id');
            $company = $this->_companyRepository->find($companyId);
            
            if (is_null($company)) {
                throw new \InvalidArgumentException(
                    'Could not find company with id: ' . $companyId
                );
            }

            $job = new Jobs();
            $job->setName($request->get('name'));
            $job->setCompanyId($company);
            $job->setDescription($request->get('description'));
            $job->setCreatedAt(new DateTimeImmutable());
            $job->setActive($active);
            $job->setPriority($priority);
            $jobSaved = $this->_jobsRepository->save($job);
            return new JsonResponse(
                [
                    'results' => [
                        'Saved new job' => $jobSaved,
                        'error' => false,
                    ]
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'results' => [
                        'error' => true,
                        'message' => $e->getMessage()
                    ]
                ]
            );
        }
    }

    /**
     * Get all jobs from the database
     *
     * @return Response
     */
    public function readJobs(): Response
    {
        $jobsArr = [];

        $rows = $this->_jobsRepository->select();

        foreach ($rows as $job) {
            $jobsArr[] = [
                'id' => $job->getId(),
                'name' => $job->getName(),
                'description' => $job->getDescription(),
                'active' => $job->getActive(),
                'priortiy' => $job->getPriority(),
                'createdAt' => $job->getCreatedAt(),
                'company' => [
                    'id' => $job->getCompany()->getId(),
                    'company' => $job->getCompany()->getName()
                    
                ]
            ];
        }

        return new JsonResponse(
            [
                'results' => [
                    'error' => false,
                    'jobs' => $jobsArr
                ]
            ]
        );
    }

    /**
     * Gets the job by the ID
     *
     * @param mixed $id 
     * 
     * @return Response
     */
    public function readJobsById(int $id): Response
    {
        try {
            $this->_jobValidator->idIsValid($id);
            $rows = $this->_jobsRepository->selectById($id);

            $jobsArr = [];
            foreach ($rows as $job) {
                $jobsArr[] = [
                    'id' => $job->getId(),
                    'name' => $job->getName(),
                    'description' => $job->getDescription(),
                    'active' => $job->getActive(),
                    'priortiy' => $job->getPriority(),
                    'createdAt' => $job->getCreatedAt(),
                    'company' => [
                        'id' => $job->getCompany()->getId(),
                        'company' => $job->getCompany()->getName()
                    ]
                ];
            }

            return new JsonResponse(
                [
                'results' => [
                    'error' =>false,
                    'jobs' => $jobsArr
                ]
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'results' => [
                        'error' => true,
                        'message' => $e->getMessage()
                    ]
                ]
            );
        }
    }

    /**
     * Gets the job by the Name
     *
     * @param mixed $name 
     * 
     * @return Response
     */
    public function readJobsByName(string $name): Response
    {
        try {
            $this->_jobValidator->nameIsValid($name);
            $rows = $this->_jobsRepository->selectByName($name);
            $jobsArr = [];
            foreach ($rows as $job) {
                $jobsArr[] = [
                    'id' => $job->getId(),
                    'name' => $job->getName(),
                    'description' => $job->getDescription(),
                    'active' => $job->getActive(),
                    'priortiy' => $job->getPriority(),
                    'createdAt' => $job->getCreatedAt(),
                    'company' => [
                        'id' => $job->getCompany()->getId(),
                        'company' => $job->getCompany()->getName()
                        
                    ]
                ];
            }

            return new JsonResponse(
                [
                'results' => [
                    'error' =>false,
                    'jobs' => $jobsArr
                ]
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'results' => [
                        'error' => true,
                        'message' => $e->getMessage()
                    ]
                ]
            );
        }
    }
  
    /**
     * Read a job by the substring of the name
     *
     * @param mixed $name 
     *  
     * @return Response
     */
    public function readJobsByNameLike(string $name): Response
    {
        try {
            $this->_jobValidator->nameIsValid($name);
            $rows = $this->_jobsRepository->selectByNameLike($name);
            $jobsArr = [];
            foreach ($rows as $job) {
                $jobsArr[] = [
                    'id' => $job->getId(),
                    'name' => $job->getName(),
                    'description' => $job->getDescription(),
                    'active' => $job->getActive(),
                    'priortiy' => $job->getPriority(),
                    'createdAt' => $job->getCreatedAt(),
                    'company' => [
                        'id' => $job->getCompany()->getId(),
                        'company' => $job->getCompany()->getName()
                        
                    ]
                ];
            }
            
            return new JsonResponse(
                [
                'results' => [
                    'error' =>false,
                    'jobs' => $jobsArr
                ]
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'results' => [
                        'error' => true,
                        'message' => $e->getMessage()
                    ]
                ]
            );
        }
    }

    /**
     * Updates a job from the database
     *
     * @param mixed $id 
     * @param mixed $request 
     * 
     * @return Response
     */
    public function updateJob(int $id, Request $request): Response
    {
        try {
            $this->_jobValidator->idIsValid($id);
            $name = $request->get('name');
            if (!empty($name)) {
                $this->_jobValidator->nameIsValid($name);
            }
            
            $requestParams = $request->query->all();
            $updateResult = $this->_jobsRepository->update($id, $requestParams);
            return new JsonResponse(
                [
                    'results' => [
                        'error' => false,
                        'rows_updated' => $updateResult
                    ]
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'results' => [
                        'error' => true,
                        'message' => $e->getMessage()
                    ]
                ]
            );
        }
    }

    /**
     * Delete a job from the database
     *
     * @param mixed $id 
     * 
     * @return Response
     */
    public function deleteJob(int $id): Response
    {
        try {
            $this->_jobValidator->idIsValid($id);
            $jobToDelete = $this->_jobsRepository->find($id);
            
            if (is_null($jobToDelete)) {
                throw new \InvalidArgumentException('Could not find job with id: ' . $id);
            }
            $deletedId = $jobToDelete->getId();
            $this->_jobsRepository->remove($jobToDelete);
            return new JsonResponse(
                [
                'results' => [
                    'error' => false,
                    'job_deleted_id' => $deletedId,
                ]
                ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'results' => [
                        'error' => true,
                        'message' => $e->getMessage()
                    ]
                ]
            );
        }
    }

    public function bulk(Request $request): Response
    {
        $jobsTxt = $this->_fileReader->_getData();
        $delete = $request->get('delete');
        if (!empty($delete && $delete == 1)) {
            $jobsFind = $this->_jobsRepository->findAll();
            $this->_jobsRepository->remove($jobsFind);
        }

        $update = $request->get('update');
        if (!empty($update) && update == 1) {
            $jobsFind = $this->_jobsRepository->findBy($jobsTxt);

            if (!empty($jobsFind)) {
                foreach ($jobsTXT as $job) {
                    $job = $this->_jobsRepository->find($jobsTxt);
                    $this->_jobsRepository->update();
                }
            } else {
                $this->_jobsRepository->save($jobsTxt);
            }
            if (empty($delete) && (empty($update))) {
                $this->_jobsRepository->save($jobsTxt);
            }
        }
    }

   

}
