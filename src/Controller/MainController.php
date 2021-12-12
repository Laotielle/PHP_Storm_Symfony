<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Repository\JeuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
#use Doctrine\Common\Persistence\ObjectManager;
#use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(JeuxRepository $jeuxRepository)
    {
        $contenu = $jeuxRepository->findAll();
        return $this->render('Mypages/homepage.html.twig', ['contenu' => $contenu ]);
    }

    /**
     * @Route("/profile/new", name="create-a-new-profile")
     */
    public function createanewprofile()
    {
        return $this->render('Mypages/createnewprofile.html.twig');
    }

    /**
     * @Route("/profile/login", name="login")
     */
    public function login()
    {
        return $this->render('Mypages/login.html.twig');
    }

    /**
     * @Route("/add_a_new_game", name="add-a-new-game")
     */
    public function addanewgame(Request $request)
    {
        $unJeu = new Jeux();
        $formJeu = $this -> createFormBuilder($unJeu)
                      -> add('nom')
                      -> add('image')
                      -> add('synopsis')
                      -> add('lien')
                        ->add('save', SubmitType::class)
                      -> getForm();

        $formJeu->handleRequest($request);
        if ($formJeu->isSubmitted() && $formJeu->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $formJeu->getData();
            $task->setDateAjout(new \DateTime());
            dd($task);
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Mypages/addanewgame.html.twig',['formJeu'=>$formJeu->createView()]);
    }
}