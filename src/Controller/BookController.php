<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\BookType;


#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/display', name: 'app_dis')]
    public function dsiplay( ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Book::class);
        $list= $repository->findAll();
            
        return $this->render('book/display.html.twig', [
            'books' => $list,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_d')]
    public function delete(BookRepository $rep,$id, 
    EntityManagerInterface $em): Response
    {
        $book=$rep->find($id);
        $em->remove($book);
        $em->flush();        
        return $this->redirectToRoute('app_dis');
    }
    #[Route('/add', name: 'app_addb')]
    public function add(ManagerRegistry $doctrine, 
    Request $request): Response
    {
        $em= $doctrine->getManager();
        $book=new Book();
        $form=$this->createForm(BookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
        $em->persist($book);
        $em->flush();        
        return $this->redirectToRoute('app_dis');
        }
        return $this->render('book/add.html.twig',
        [
            'f'=>$form
        ]);

    }
}
