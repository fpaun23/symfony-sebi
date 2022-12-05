<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Psr\Log\LoggerInterface;

/**
 * new class for company controller
 */
class CompanyController extends AbstractController
{

    public $form;
    public $name;
    public $description;
    public $data;
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger=$logger;
    }
    
    /**
     * loadTemplate
     *
     * @return Response
     */
    public function loadTemplate(): Response
    {
        return $this->render('company/index.html.twig');
    }

     /**
     * loadTemplate
     *
     * @param  mixed $request
     * @return Response
     */
    // public function addCompany(Request $request): Response
    // {
    //     $this->form = $this->createFormBuilder()
    //         ->add('name', TextType::class)
    //         ->add('description', TextType::class)
    //         ->add('Add', SubmitType::class)
    //         ->getForm();
   
    //     $this->form->handleRequest($request);

    //     if ($this->form->isSubmitted() && $this->form->isValid()) {

    //         $submittedData = $this->form->getData();
    //         $name = $submittedData['name'];
    //         $description = $submittedData['description'];
    
    //         $this->logger->error(
    //             "Datele au fost salvate",
    //             [json_encode(['company_name' => $name, 'company_description' => $description])]
    //         );
            
    //         return $this->redirectToRoute('company_controller');
    //     }

    //     return $this->render('company/index.html.twig', [
    //         'form'=>$this->form->createView()
            
    //     ]);
    // }
    public function addCompany(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $company = new Company();
        $company->setName('CompanyName');
        $entityManager->persist($company);
        $entityManager->flush();

        return new Response('Saved new company with id '.$company->getId());
    }
    public function readCompany(ManagerRegistry $doctrine): Response
    {
        $company = $doctrine->getRepository(Company::class)->findAll();
        return new Response(json_encode($company));
    }
    public function updateCompany(ManagerRegistry $doctrine, int $id): Response
    {
        $updateId = null;
        $entityManager = $doctrine->getManager();
        $company = $entityManager->getRepository(Company::class)->find($id);
        if (!empty($company)) {
            $updateId = $company->getId();
            $company->setName('.NetDev');
            $entityManager->flush();
        }
        return new JsonResponse([
            'update' => !empty($updateId),
            'updateId' => $updateId
        ]);
    }
    public function deleteCompany(ManagerRegistry $doctrine, int $id): Response
    {
        $deletedId = null;
        $entityManager = $doctrine->getManager();
        $company = $entityManager->getRepository(Company::class)->find($id);
        if (!empty($company)) {
            $deletedId = $company->getId();
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return new JsonResponse([
            'detleted' => !empty($deletedId),
            'deleteId' => $deletedId
        ]);
    }
}
