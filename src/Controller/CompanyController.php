<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Validator\CompanyValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * new class for company controller
 */
class CompanyController extends AbstractController
{

    private CompanyRepository $companyRepository;
    private CompanyValidator $companyValidator;
   
    /**
     * __construct
     *
     * @param  mixed $companyRepository
     * @param  mixed $companyValidator
     * @return void
     */
    public function __construct(CompanyRepository $companyRepository, CompanyValidator $companyValidator)
    {
        $this->companyRepository = $companyRepository;
        $this->companyValidator = $companyValidator;
    }
        
    /**
     * addCompany
     *
     * @param  mixed $request
     * @return Response
     */
    public function addCompany(Request $request): Response
    {
        try {
            $name = $request->get('name');
            $this->companyValidator->nameIsValid(($name));
            $company = new Company();
            $company->setName($request->get('name'));

            $companySaved = $this->companyRepository->save($company);
            return new JsonResponse(
                [
                    'results' => [
                        'Saved new company' => $companySaved,
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
     * get all companies from the database
     *
     * @param  mixed $doctrine
     * @return Response
     */
    public function readCompany(): Response
    {

        $rows = $this->companyRepository->select();
        return new JsonResponse([
            $rows
        ]);
    }

    /**
     * gets the company by the ID
     *
     * @param  mixed $id
     * @return Response
     */
    public function readCompanyByID(int $id): Response
    {
        try {
            $this->companyValidator->idIsValid($id);

            $rows = $this->companyRepository->selectById($id);
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
     * gets the company by the Name
     *
     * @param  mixed $name
     * @return Response
     */
    public function readCompanyByName(string $name): Response
    {
        try {
            $this->companyValidator->nameIsValid($name);
            $rows = $this->companyRepository->selectByName($name);
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
     * readCompanyByNameLike
     *
     * @param  mixed $name
     * @return Response
     */
    public function readCompanyByNameLike(string $name): Response
    {
        try {
            $this->companyValidator->nameIsValid($name);
            $rows = $this->companyRepository->selectByNameLike($name);
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
     * updates a company from the database
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return Response
     */
    public function updateCompany(int $id, Request $request): Response
    {
        try {
            $this->companyValidator->idIsValid($id);
            $name = $request->get('name');
            $this->companyValidator->nameIsValid($name);
            $requestParams = $request->query->all();
            $updateResult = $this->companyRepository->update($id, $requestParams);

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
     * delete a company from the database
     *
     * @param  mixed $id
     * @return Response
     */
    public function deleteCompany(int $id): Response
    {
        try {
            $this->companyValidator->idIsValid($id);
            $deletedId = null;
            $compToDelete = $this->companyRepository->find($id);
            if (!empty($compToDelete)) {
                $deletedId = $compToDelete;
                $this->companyRepository->remove($compToDelete);
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
