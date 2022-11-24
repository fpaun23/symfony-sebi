<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use App\Controller\ValidateController\DataValidatorInterface;

/**
 * new class for contact controller
 */
class ContactController extends AbstractController
{
    public $page_title = 'Contact Controller';
    public $error_msg = '';

    private $logger;

    private $validator;
    private $name = "";
    private $description = "";
    private $email = "";
        
    /**
     * __construct
     *
     * @param  mixed $logger
     * @param  mixed $validator
     * @return void
     */
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
            'error_msg' =>$this->error_msg,
            'name' =>$this->name,
            'description' => $this->description,
            'email' => $this->email
        ]);
    }
    
    /**
     * Ads the data in the form in a json or displays the errors
     *
     * @param  mixed $request
     * @return Response
     */
    public function addContact(Request $request): Response
    {
        $this->name = $request->request->get('name');
        $this->description = $request->request->get('description');
        $this->email = $request->request->get('email');
        $validate = $this->validator->contactValidate([$this->name, $this->description, $this->email]);
        if ($validate == true) {
            $this->logger->notice(
                "Your information has been submitted)",
                [json_encode(['name' => $this->name, 'email' => $this->email, 'description' => $this->description])]
            );
            return $this->redirectToRoute('contact_controller');
        } else {
            $this->error_msg = $this->validator->err();
            return $this->render('contact/index.html.twig', [
                'page_title'=>$this->page_title,
                'error_msg' =>$this->error_msg,
                'name' =>$this->name,
                'description' => $this->description,
                'email' => $this->email
            ]);
        }
    }
}
