<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Service\ContactService;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function form(Request $request, ContactService $contactService ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if ($form->get('service')->getData() == NULL) {
                $this->addFlash('danger', 'Vous n\'avez pas choisi de service a contacter !');
                return $this->redirectToRoute('contact');
            }
            $contact = $form->getData();

            $contactService->persistContact($contact);
            return  $this->redirectToRoute('contact');
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
