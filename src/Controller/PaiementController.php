<?php

namespace App\Controller;

use DateTime;
use Paydunya;
use App\Entity\Subscription;
use App\Repository\UserRepository;
use App\Repository\PacksRepository;
use Paydunya\Checkout\CheckoutInvoice;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{
    /**
     * @Route("/status/{idpack}/{iduser}", name="status")
     */
    public function index($idpack,$iduser,PacksRepository $repac,UserRepository $repuser)
    {
        Setup::setMasterKey("sO4bJTB1-VGno-uwPH-HRMT-6C5H4kNFu8Qn");
Setup::setPrivateKey("live_private_542NI1K1OydZQRPB1mE2uWFgraY");
Setup::setToken("9tIQowOQQxlNEhQaVIzl");
Setup::setMode("live");
Setup::setPublicKey("live_public_eGHyRPJlnkWZpCRWoeaqorkgTcM");
//Configuration des informations de votre service/entreprise
//Setup::setMasterKey("sO4bJTB1-VGno-uwPH-HRMT-6C5H4kNFu8Qn");
//Setup::setPublicKey("test_public_tzTd3klc9WYzradGceuoHmaPvKR");
//Setup::setPrivateKey("test_private_NHEmeiZn3nUAyq0sYprqRhJlYxH");
//Setup::setToken("FWqNtl4ydmUdpsCcSlKa");
//Setup::setMode("test"); // Optionnel. Utilisez cette option pour les paiements tests.
Store::setLogoUrl("https://nasrulex.com/assets/img/Nasurlex-logo.png");
Store::setName("NASRULEX"); // Seul le nom est requis
Store::setTagline("Plateforme de Documentation Juridique");
Store::setPhoneNumber("+221 77 377 77 66");
Store::setWebsiteUrl("http://nasrulex.com");
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
            if($this->getUser()){
                $subs->setUser($this->getUser()) ;
            }else{
                $subs->setUser($repuser->find($iduser));
            }
            $subs->setPack($pack)
                ->setDateDebut(new DateTime())
                ->setDateFin($datefin)
                ->setLinkFacture($co->getReceiptUrl());
                $em->persist($subs);
                $em->flush();
                $this->addFlash("success","Votre abonnement est validé avec succés ");
            return $this->redirectToRoute('abonnement');
        }else{
            $this->addFlash("danger","Solde Insufisant ,Recharger votre compte si vous penser que c'est une erreur Contacter nous");
            return $this->redirectToRoute('dashbord');
        }
        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
        ]);
    }
}
