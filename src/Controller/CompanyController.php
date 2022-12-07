<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
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
    /**
     * __construct
     *
     * @param  mixed $companyRepository
     * @return void
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    
    public function addCompany(Request $request): Response
    {
        $company = new Company();
        $company->setName($request->get('name'));
        $companySaved = $this->companyRepository->save($company);
        return new JsonResponse(
            [
                'Saved new company' => $companySaved
            ]
        );
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

        $rows = $this->companyRepository->selectById($id);
        return new JsonResponse([
            $rows
        ]);
    }
    /**
     * gets the company by the Name
     *
     * @param  mixed $name
     * @return Response
     */
    public function readCompanyByName(string $name): Response
    {

        $rows = $this->companyRepository->selectByName($name);
        return new JsonResponse([
            $rows
        ]);
    }
    
    public function readCompanyByNameLike(string $name): Response
    {

        $rows = $this->companyRepository->selectByNameLike($name);
        return new JsonResponse([
            $rows
        ]);
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
        $requestParams = $request->query->all();
        $updateResult = $this->companyRepository->update($id, $requestParams);

        return new JsonResponse(
            [
                'rows_updated'=> $updateResult
            ]
        );
    }
    /**
     * delete a company from the database
     *
     * @param  mixed $id
     * @return Response
     */
    public function deleteCompany(int $id): Response
    {
        $deletedId = null;
        $compToDelete = $this->companyRepository->find($id);
        if (!empty($compToDelete)) {
            $deletedId = $compToDelete;
            $this->companyRepository->remove($compToDelete);
        }

        return new JsonResponse([
            'deleted' => !empty($deletedId),
        ]);
    }
}
