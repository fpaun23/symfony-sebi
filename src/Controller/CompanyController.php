<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * new class for company controller
 */
class CompanyController extends AbstractController
{
    public $page_title = 'Company Controller';
    public $name = 'Devnest';
    
    /**
     * Loads the template for the company controller
     *
     * @return Response
     */
    public function loadTemplate(): Response
    {
        return $this->render('company/index.html.twig', [
            'name' =>$this->name,
            'page_title'=>$this->page_title,
        ]);
    }
}
