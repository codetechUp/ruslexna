<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    
    /**
     * @Route("/admin/contact", name="contact.add")
     */
    public function addService(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        if ($request->request->count()>0) {
            $contact = new Contact();

           $contact->setNomComplet($request->request->get('nomComplet'))
                   ->setUsername($request->request->get('username'))
                   ->setTelephone($request->request->get('telephone'))
                   ->setMessage($request->request->get('message'));
            $entityManager->persist($contact);
            $entityManager->flush();


            return $this->redirectToRoute('home');

        }

        return $this->render('home/index.html.twig', [
            'addservice' => true,
            'title'=>'Ajout Service'

        ]);
    }
}
