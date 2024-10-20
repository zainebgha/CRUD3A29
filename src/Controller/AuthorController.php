<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AuthorType;
use App\Entity\Author;
#[Route('/author')]
class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/displayA', name: 'app_displayA')]
    public function displayA(AuthorRepository $rep): Response
    {
        $authors=$rep->findAll();
        return $this->render('author/display.html.twig',
    [
        'authors'=>$authors
    ]);
    }
    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(AuthorRepository $rep,$id,
     EntityManagerInterface $em): Response
    {
        $author=$rep->find($id);
        $em->remove($author);
        $em->flush();
        
        return $this->redirectToRoute('app_displayA');
    }

    #[Route('/ajout', name: 'app_ajout')]
    public function ajouter(ManagerRegistry $doctrine,
     Request $request): Response
    {
        $author=new Author();
        $em= $doctrine->getManager();
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
        $em->persist($author);
        $em->flush();        
        return $this->redirectToRoute('app_displayA');
        }
        return $this->render('author/ajout.html.twig',
        [
            'f'=>$form
        ]);

        
    }




    #[Route('/add', name: 'app_adda')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $em= $doctrine->getManager();
        $author=new Author();
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
        $em->persist($author);
        $em->flush();        
        return $this->redirectToRoute('app_displayA');
        }
        return $this->render('author/add.html.twig',
        [
            'f'=>$form
        ]);

    }
}
