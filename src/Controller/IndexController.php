<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use phpDocumentor\Reflection\Types\Context;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Entity\Opinion;
use App\Repository\OpinionRepository;
use App\Form\ContactFormType;
use App\Form\OpinionFormType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

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


    // il s'agit d'un formulaire de contact simple mais customiser avec le templatedEmail et les données ne sont pas persistées en bdd.

    /**
     * @Route("/", name="index")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function form(Request $request, MailerInterface $mailer ): Response
    {
        
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $message = (new TemplatedEmail())
                ->from($contactFormData['email'])
                ->to('jsd3v@jsgame-on.fr')
                //->subject($contactFormData['sujet'])
                ->priority(Email::PRIORITY_HIGH)
                ->htmlTemplate('emails/response.html.twig')
                ->Context([
                    'nom' =>$contactFormData['nom'],
                    'prenom'=>$contactFormData['prenom'],
                    //'sujet'=>$contactFormData['sujet'],
                    'message'=>$contactFormData['text'],
            ]);
            $mailer->send($message);

            $this->addFlash('success', 'Votre message a été envoyé, je vous recontacte dès que possible');
            return $this->redirectToRoute('index',[], Response::HTTP_SEE_OTHER);
        }elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Il y a eut une erreur lors de l\'envoi de votre message');
        }
        $response = new Response(null, $form->isSubmitted() ? 422 : 200);
        return $this->render('index/index.html.twig', [
            'contact' =>$form -> createView(),
        ], $response);
    }

}
