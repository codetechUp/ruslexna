<?php

namespace App\Controller;

use Paydunya\Checkout\Store;
use App\Repository\PacksRepository;
use Paydunya\Checkout\CheckoutInvoice;
use App\Repository\CategorieRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
       Store::setReturnUrl("https://".$_SERVER['HTTP_HOST']."/status/$idpack/$iduser");       //Store::setReturnUrl("http://127.0.0.1:8000/status/".$idpack."/".$iduser);
           
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
        $this->addFlash("success","Veillez vous inscrire avant de payer un pack");

           return $this->redirectToRoute('inscription');

       }
    }
}
