<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
    #[Route('/twig', name: 'app_twig')]
    public function twig(): Response
    {
        $name='med';
        $age=5;
        $dateN="20-04-2002";
        $books=array(
            array('id'=>4,'title'=>'clean code','author'=>'jhon'),
            array('id'=>66,'title'=>'refactoring','author'=>'sarra'),
            array('id'=>9,'title'=>'deep work','author'=>'test'),
        );
        return $this->render('product/twig.html.twig',
    [
        'n'=>$name,
        'age'=>$age,
        'dateN'=>$dateN,
        'books'=>$books

    ]);
    }

    #[Route('/twin/{id}', name: 'app_twin')]
    public function twin($id): Response
    {
        return $this->render('product/twin.html.twig');
    }
}
