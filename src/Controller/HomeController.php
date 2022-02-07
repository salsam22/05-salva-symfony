<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ShirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(ShirtRepository $shirtRepository, CategoryRepository $categoryRepository): Response
    {
        $shirts = $shirtRepository->findAll();
        $categories = $categoryRepository->findAll();
        return $this->render('home.html.twig', [
            "shirts"=>$shirts,
            "categories"=>$categories
        ]);
    }
}
