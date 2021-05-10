<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, ContactService $contactService, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $contactService->persistContact($contact);

            $email = (new TemplatedEmail())
                    ->from($form->get('email')->getData())
                    ->to('fedodev55@gmail.com')
                    ->subject($form->get('subject')->getData())
                    ->htmlTemplate('contact/contact_me.html.twig')
                    ->context([
                        'mail' => $form->get('email')->getData(),
                        'subject' => $form->get('subject')->getData(),
                        'message' => $form->get('message')->getData(),

                    ]);
            $mailer->send($email);
            // $this addFlash('message', 'message Envoyé !');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
        'form' => $form->createView(),
        ]);
       
    }
}