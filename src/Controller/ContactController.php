<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * new class for contact controller
 */
class ContactController extends AbstractController
{
    public $page_title = 'Contact Controller';
    public $user = 'Sebastian';
    
    /**
     * Loads the template for the Contact controller
     *
     * @return Response
     */
    public function loadTemplate(): Response
    {
        return $this->render('contact/index.html.twig', [
            'user' =>$this->user,
            'page_title'=>$this->page_title,
        ]);
    }
}
