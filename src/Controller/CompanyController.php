<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{
    public $page_title = 'Company Controller';
    public $name = 'Devnest';
    public function loadTemplate(): Response
    {
        return $this->render('company/index.html.twig', [
            'name' =>$this->name,
            'page_title'=>$this->page_title,
        ]);
    }
}
