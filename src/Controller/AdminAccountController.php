<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('admin/account/login.html.twig', [

            'hasError'=>$error !==null,
            'username'=>$username
            
        ]);
    }

    /**
     * Permet la deconnexion de la partie admin
     * @Route("/admin/logout",name="admin_account_logout")
     * @return void
     */
    public function logout(){

    }

    /**
     * Permet de modifier une annonce dans la partie admin
     * @Route("admin/ads/{id}/edit",name="admin_ads_edit")
     * @param Ad $ad
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Ad $ad,Request $request,ObjectManager $manager){

        $form = $this->createForm(AnnonceType::class,$ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash('success',"L'annonce a bien été modifiée");

        }

        return $this->render('admin/ad/edit.html.twig',[
            'ad'=>$ad,
            'form'=>$form->createView()
        ]);

    }

        /**
         * Suppression d une annonce
         * @Route("/admin/ads/{id}/delete",name="admin_ads_delete")
         * @param Ad $ad
         * @param ObjectManager $manager
         * @return Response
         */
    public function delete(Ad $ad,ObjectManager $manager){

        if(count($ad->getBookings()) > 0){

            $this->addFlash("warning","Vous ne pouvez pas supprimer une annonce qui contient des réservations.");
        }else{

        $manager->remove($ad);
        $manager->flush();

        $this->addFlash('success',"L'annonce <strong>{$ad->getTitle()}</strong> a bien été supprimée.");

    }

        return $this->redirectToRoute("admin_ads_list");

    }
}
