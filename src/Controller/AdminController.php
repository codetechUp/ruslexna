<?php

namespace App\Controller;

use App\Entity\Packs;
use App\Form\PackType;
use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\PacksRepository;
use App\Repository\DocumentRepository;
use App\Repository\CategorieRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/dashbord", name="dashbord")
     */
    public function dash()
    {
        return $this->render('admin/dash.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/docs", name="addDoc")
     */
    public function addDoc(Request $req, CategorieRepository $cat,SousCategorieRepository $scat)
    {
        $categories=$cat->findAll();
        $doc=new Document();
         //creation formulaire 
         $form=$this->createForm(DocumentType::class,$doc);
         //recuperation des donnees modifies
         $form->handleRequest($req);
         if($form->isSubmitted() && $form->isValid()){
             $em=$this->getDoctrine()->getManager();
             $pdf=file_get_contents($doc->getFichier());
             $doc->setFichier($pdf);
             $cts= explode("-",$req->request->get('categorie'));
             $categorie=$cat->find($cts[0]);
             $scategorie=$scat->find($cts[1]);
             $doc->setCategorie($categorie);
             $doc->setSouscat($scategorie);
             
             //Modification des donnees dans le db
             $em->persist($doc);
             $em->flush();
             //Ajout msg alert de success
             $this->addFlash("success","Ajouter avec success");

             //Redirection
             return $this->redirectToRoute('dashbord');
 
         }
     
         return $this->render('admin/index.html.twig', [
             'form' => $form->createView(),
             'categories'=>$categories
 
         ]);
     }
    /**
     * @Route("/admin/edit/{id}", name="editDoc")
     */
    public function editDoc(Request $req,$id,DocumentRepository $docR, CategorieRepository $cat,SousCategorieRepository $scat)
    {
        $categories=$cat->findAll();
        $doc=$docR->find($id);
        
         //creation formulaire 
         $form=$this->createForm(DocumentType::class,$doc);
         //recuperation des donnees modifies
         $form->handleRequest($req);
         if($form->isSubmitted() && $form->isValid()){
             $em=$this->getDoctrine()->getManager();
             if(!empty($doc->getFichier())){
                $pdf=file_get_contents($doc->getFichier());
                $doc->setFichier($pdf);
             }
             
             $cts= explode("-",$req->request->get('categorie'));
             $categorie=$cat->find($cts[0]);
             $scategorie=$scat->find($cts[1]);
             $doc->setCategorie($categorie);
             $doc->setSouscat($scategorie);
             
             //Modification des donnees dans le db

             $em->flush();
             //Ajout msg alert de success
             $this->addFlash("success","Modifier avec success");

             //Redirection
             return $this->redirectToRoute('dashbord');
 
         }
     
         return $this->render('admin/edit.html.twig', [
             'form' => $form->createView(),
             'categories'=>$categories
 
         ]);
     }
     /**
     * @Route("/admin/remove/{id}", name="removeDoc")
     */
    public function supDoc(Request $req,$id,DocumentRepository $docR, CategorieRepository $cat,SousCategorieRepository $scat)
    {
        $em=$this->getDoctrine()->getManager();
        $doc=$docR->find($id);
        $em->remove($doc);
        $em->flush();
        //Ajout msg alert de success
        $this->addFlash("danger","Supprimer avec success");

        //Redirection
        return $this->redirectToRoute('dashbord');
    }
     /**
     * @Route("/admin/rv/{id}", name="removePack")
     */
    public function sup(Request $req,$id,PacksRepository $pk, CategorieRepository $cat,SousCategorieRepository $scat)
    {
        $em=$this->getDoctrine()->getManager();
        $doc=$pk->find($id);
        if($doc->getPrincipal()== true ){
            $this->addFlash("danger","Impossible de Supprimer un pack principal");

        //Redirection
        return $this->redirectToRoute('dashbord');
        }
        $em->remove($doc);
        $em->flush();
        //Ajout msg alert de success
        $this->addFlash("danger","Supprimer avec success");

        //Redirection
        return $this->redirectToRoute('dashbord');
    }


    /**
     * @Route("/admin/addpack", name="addPack")
     */
    public function addpack(Request $req, CategorieRepository $cat,SousCategorieRepository $scat)
    {
        
        $packs=new Packs();
         //creation formulaire 
         $form=$this->createForm(PackType::class,$packs);
         //recuperation des donnees modifies
         $form->handleRequest($req);
         if($form->isSubmitted() && $form->isValid()){
             $em=$this->getDoctrine()->getManager();
             //Modification des donnees dans le db
             $em->persist($packs);
             $em->flush();
             //Ajout msg alert de success
             $this->addFlash("success","Ajouter avec success");

             //Redirection
             return $this->redirectToRoute('dashbord');
 
         }
     
         return $this->render('admin/addpack.html.twig', [
             'form' => $form->createView(),
 
         ]);
     }
/**
     * @Route("/admin/pack", name="Pack")
     */
public function pack(PacksRepository $p){
    $packs=$p->findAll();
    return $this->render('admin/packs.html.twig', [
        "packs"=>$packs

    ]);
}

/**
* @Route("/admin/pack/{id}/edit", name="editPack")
*/
public function editpack(PacksRepository $p,$id,Request $req){
    $packs=$p->find($id);
         //creation formulaire 
         $form=$this->createForm(PackType::class,$packs);
         //recuperation des donnees modifies
         $form->handleRequest($req);
         if($form->isSubmitted() && $form->isValid()){
             $em=$this->getDoctrine()->getManager();
             //Modification des donnees dans le db
             $em->flush();
             //Ajout msg alert de success
             $this->addFlash("success","modifier avec success");

             //Redirection
             return $this->redirectToRoute('Pack');
 
   
}
return $this->render('admin/editpacks.html.twig', [
    'form' => $form->createView(),

]);
}
}
