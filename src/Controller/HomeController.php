<?php

// namespace : chemin du controller

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// pour créer une page, on a besoin : 1- une fonction publique (une classe) / 2- une route (url) / 3- une réponse

class HomeController extends Controller {

    /**
     * création de notre premiere route
     * @Route("/", name="homepage")
     */

    public function home(){

        $noms = ['Durand'=>'visiteur','Francois'=>'admin','Dupont'=>'contibuteur'];
        return $this->render('home.html.twig',['titre'=>'Site d\'annonces','acces'=>'admin','tableau'=>$noms]);

    }

    /**
     * Montre la page qui salue l'utilisateur
     * 
     * @Route("/hello/{nom}",name="hello")
     * @Route("/hello",name="hello-base")
     * @Route("/hello/{nom}/acces/{acces}")
     * @return void
     */

    public function hello($nom='anonyme',$acces='visiteur'){

        return $this->render('hello.html.twig',['title'=>'Page de profil','nom'=>$nom,'acces'=>$acces]);

    }

}