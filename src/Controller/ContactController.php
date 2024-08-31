<?php

namespace App\Controller;

use App\DTO\ContactDto;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;





class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $data = new ContactDto();
        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($data->email)
                ->to('bite-force@jlafsmnu.mailosaur.net')
                ->subject('Time for Symfony Mailer!')
                ->text($data->content);

            $mailer->send($email);








            $this->addFlash('success', 'votre email a bien été envoyé');
            return $this->redirectToRoute('app_main');
        }


        return $this->render('contact/contactez.html.twig', [
            'form' => $form,
        ]);
    }
}
