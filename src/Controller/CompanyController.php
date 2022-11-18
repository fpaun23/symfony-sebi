<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
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
     * Loads the template for the company controller
     *
     * @return Response
     */
    public function loadTemplate(): Response
    {
        $this->form = $this->createFormBuilder()
        ->add('name', TextType::class)
        ->add('description', TextType::class)
        ->add('Add', SubmitType::class)
        ->getForm();

        return $this->render('company/index.html.twig', [
            'form'=>$this->form->createView()
        ]);
    }
    public function addCompany()
    {
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->name = $this->form->getData();
            $this->description = $this->form->getData();
            $this->data = $this->form->all();
            $this->logger->notice("Datele au fost salvate", [$this->name, $this->description]);
            return $this->render('company/index.html.twig', [
                'form'=>$this->form->createView()
            ]);
        } else {
            $this->logger->error("Completati campurile!");
            $this->form=$this->createFormBuilder()
            ->add($this->data)
            -getForm();

            return $this->render('company/index.html.twig', [
            'form'=>$this->form->createView()
            
            ]);
        }
    }
}
