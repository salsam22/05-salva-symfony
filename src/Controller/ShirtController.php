<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShirtController extends AbstractController
{
    /**
     * @Route("/shirt", name="shirt")
     */
    public function index(): Response
    {
        return $this->render('shirt/shirt.html.twig', [
            'controller_name' => 'ShirtController',
        ]);
    }

    /**
     * @Route ("/shirt/{id}", name="shirt_show")
     */
    public function show($id) {
        return new Response("Shirt data with id: $id");
    }
}
