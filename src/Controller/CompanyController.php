<?php

declare(strict_types=1);

namespace App\Controller;

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
    public function addCompany(Request $request): Response
    {
        $this->form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('Add', SubmitType::class)
            ->getForm();
   
        $this->form->handleRequest($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {

            $submittedData = $this->form->getData();
            $name = $submittedData['name'];
            $description = $submittedData['description'];
    
            $this->logger->error(
                "Datele au fost salvate",
                [json_encode(['company_name' => $name, 'company_description' => $description])]
            );
            
            return $this->redirectToRoute('company_controller');
        }

        return $this->render('company/index.html.twig', [
            'form'=>$this->form->createView()
            
        ]);
    }
}
