<?php

namespace App\Controller;

use App\Repository\ShirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(ShirtRepository $shirtRepository): Response
    {

        $shirts = $shirtRepository->findAll();

        return $this->render('home.html.twig', [
            "shirts"=>$shirts
        ]);
    }
}
