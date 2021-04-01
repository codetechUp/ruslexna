<?php

namespace App\Controller;

use DateTime;
use App\Entity\Subscription;
use App\Repository\PacksRepository;
use Paydunya\Checkout\CheckoutInvoice;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{
    /**
     * @Route("/status/{idpack}/{iduser}", name="status")
     */
    public function index($idpack,$iduser,PacksRepository $repac)
    {
        $em=$this->getDoctrine()->getManager();
        $co = new CheckoutInvoice();
        $pack=$repac->find($idpack);
        if ($co->confirm()){
            $date=new DateTime();
            $y=$date->format('Y');
            $d=$date->format('d');
            $m=$date->format('m');
            $datefin=new DateTime(($y+1)."-$m-$d");
            $subs=new Subscription();
            $subs->setUser($this->getUser())
                ->setPack($pack)
                ->setDateDebut(new DateTime())
                ->setDateFin($datefin)
                ->setLinkFacture($co->getReceiptUrl());
                $em->persist($subs);
                $em->flush();
                $this->addFlash("success","Votre abonnement est validé avec succés ");
            return $this->redirectToRoute('abonnement');
        }
        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }
}
