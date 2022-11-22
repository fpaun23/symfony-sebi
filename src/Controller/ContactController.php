<?php

declare(strict_types=1);

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use App\Controller\ValidateController\DataValidatorInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * new class for contact controller
 */
class ContactController extends AbstractController
{
    public $page_title = 'Contact Controller';
    

    private $logger;
    private $validator;
    private ClassMetaData $valid;
    public function __construct(LoggerInterface $logger, DataValidatorInterface $validator)
    {
        $this->logger=$logger;
        $this->validator=$validator;
    }
    
    /**
     * Loads the template for the Contact controller
     *
     * @return Response
     */
    public function loadTemplate(): Response
    {
        return $this->render('contact/index.html.twig', [
            'page_title'=>$this->page_title,
        ]);
    }

    public function addContact(Request $request): Response
    {
        
     
       
        return $this->loadTemplate();
    }
}
