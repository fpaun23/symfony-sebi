<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    public $page_title = 'Contact Controller';
    public $user = 'Sebastian';
    public function loadTemplate(): Response
    {
        return $this->render('contact/index.html.twig', [
            'user' =>$this->user,
            'page_title'=>$this->page_title,
        ]);
    }
}
