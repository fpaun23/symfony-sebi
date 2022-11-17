<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * new class for home controller
 */
class HomeController extends AbstractController
{
    public $Contact = 'Contact';
    public $Company = 'Company';
        
    /**
     * Loads the template for the home controller
     *
     * @return Response
     */
    public function loadTemplate(): Response
    {
        return $this->render('home/index.html.twig', [
            'Contact' =>$this->Contact,
            'Company'=>$this->Company,
        ]);
    }
}
