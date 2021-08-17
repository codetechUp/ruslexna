<?php

namespace App\Controller;

use Paydunya\Checkout\Store;
use App\Repository\PacksRepository;
use Paydunya\Checkout\CheckoutInvoice;
use App\Repository\CategorieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Paydunya\Checkout;
use Paydunya\CustomData;
use Paydunya\Paydunya;
use Paydunya\Setup;
use Paydunya\Utilities;
class TarifController extends AbstractController
{
    
  
      /**
     * @Route("/tarif", name="tarif")
     */
    public function tarif(CategorieRepository $cat,PacksRepository $repac){
        $categories=$cat->findAll();
        $packs=$repac->findBy(array("principal" => true));
        
        return $this->render('Tarif/index.html.twig',[
            'Home' => true,
            "date"=>date_format(new \DateTime(),"Y"),
            "categories"=>$categories,
            "packs"=>$packs

        ]);

    }
     /**
     * @Route("/paiement/{id}", name="paiement")
     */
    public function paye($id,PacksRepository $repac){
       if($this->getUser()){
        $pack=$repac->find($id);
        $idpack=$id;
        $iduser=$this->getUser()->getId();
 //dump($_SERVER['HTTP_HOST']);
       // dd("http://".$_SERVER['HTTP_HOST']."/status/$idpack/$iduser");
     Store::setReturnUrl("https://".$_SERVER['HTTP_HOST']."/status/$idpack/$iduser");       
      //Store::setReturnUrl("http://127.0.0.1:8000/status/".$idpack."/".$iduser);
      Store::setLogoUrl("https://nasrulex.com/assets/img/Nasurlex-logo.png");
Store::setName("NASRULEX"); // Seul le nom est requis
Store::setTagline("Plateforme de Documentation Juridique");
Store::setPhoneNumber("+221 77 377 77 66");
Store::setWebsiteUrl("https://nasrulex.com");
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
           
        $price=$pack->getPrice();
       
        $invoice = new CheckoutInvoice();
        $total_amount = 0;
        
        $invoice->addItem("PACK ".$pack->getLibelle(),1,$price,$price);
        
        $invoice->setTotalAmount($price);
       
        
        if($invoice->create()) {
            
            return $this->redirect($invoice->getInvoiceUrl());
         
        }else{
           dd($invoice->response_text);
        }
       }else{
        $this->addFlash("success","Veuillez vous inscrire avant de payer un pack");

           return $this->redirectToRoute('inscription');

       }
    }
}
