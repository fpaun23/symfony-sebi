<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Jobs;
use App\Repository\CompanyRepository;
use App\Repository\JobsRepository;
use App\Validator\CompanyValidator;
use App\Validator\JobValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * new class for company controller
 */
class JobController extends AbstractController
{

    private JobsRepository $jobsRepository;
    private JobValidator $jobValidator;
    private CompanyRepository $companyRepository;
   
    /**
     * __construct
     *
     * @param  mixed $companyRepository
     * @param  mixed $companyValidator
     * @return void
     */
    public function __construct(JobsRepository $jobsRepository, JobValidator $jobValidator, CompanyRepository $companyRepository)
    {
        $this->jobsRepository = $jobsRepository;
        $this->jobValidator = $jobValidator;
        $this->companyRepository = $companyRepository;
    }
        
    /**
     * add job
     *
     * @param  mixed $request
     * @return Response
     */
    public function addJob(Request $request): Response
    {
        try {
            $name = $request->get('name');
            $this->jobValidator->nameIsValid($name);
            $job = new Jobs();
            $job->setName($request->get('name'));
            $companyId = $request->get('company_id');
            $company = $this->companyRepository->find($companyId);
            $job->setCompanyId($company);
            $jobSaved = $this->jobsRepository->save($job);
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
     * get all jobs from the database
     *
     * @param  mixed $doctrine
     * @return Response
     */
    public function readJobs(): Response
    {

        $rows = $this->jobsRepository->select();
        return new JsonResponse([
            $rows
        ]);
    }

    /**
     * gets the job by the ID
     *
     * @param  mixed $id
     * @return Response
     */
    public function readJobsById(int $id): Response
    {
        try {
            $this->jobValidator->idIsValid($id);

            $rows = $this->jobsRepository->selectById($id);
            return new JsonResponse([
                'results' => [
                    'error' =>false,
                    $rows
                ]
            ]);
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
     * gets the job by the Name
     *
     * @param  mixed $name
     * @return Response
     */
    public function readJobsByName(string $name): Response
    {
        try {
            $this->jobValidator->nameIsValid($name);
            $rows = $this->jobsRepository->selectByName($name);
            return new JsonResponse([
                'results' => [
                    'error' =>false,
                    $rows
                ]
            ]);
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
     * read a job by the substring of the name
     *
     * @param  mixed $name
     * @return Response
     */
    public function readJobsByNameLike(string $name): Response
    {
        try {
            $this->jobValidator->nameIsValid($name);
            $rows = $this->jobsRepository->selectByNameLike($name);
            return new JsonResponse([
                'results' => [
                    'error' =>false,
                    $rows
                ]
            ]);
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
     * updates a job from the database
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return Response
     */
    public function updateJob(int $id, Request $request): Response
    {
        try {
            $this->jobValidator->idIsValid($id);
            $name = $request->get('name');
            $this->jobValidator->nameIsValid($name);
            $requestParams = $request->query->all();
            $updateResult = $this->jobsRepository->update($id, $requestParams);

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
     * delete a job from the database
     *
     * @param  mixed $id
     * @return Response
     */
    public function deleteJob(int $id): Response
    {
        try {
            $this->jobValidator->idIsValid($id);
            $deletedId = null;
            $jobToDelete = $this->jobsRepository->find($id);
            if (!empty($compToDelete)) {
                $deletedId = $compToDelete;
                $this->jobsRepository->remove($jobToDelete);
            }

            return new JsonResponse([
                'results' => [
                    'error' => false,
                    'deleted' => !empty($deletedId),
                ]
            ]);
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
}
