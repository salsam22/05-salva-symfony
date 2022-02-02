<?php

namespace App\Controller;

use App\Repository\ShirtRepository;
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
    public function show($id, ShirtRepository $shirtRepository) {

        $shirt = $shirtRepository->find($id);
        return $this->render('shirt/shirt.html.twig', [
            'shirt' => $shirt,
        ]);
    }
}
