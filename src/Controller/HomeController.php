<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ShirtRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{



    /**
     * @Route("/", name="home")
     */
    public function home(ShirtRepository $shirtRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $shirts = $shirtRepository->findAll();
        $categories = $categoryRepository->findAll();
        $appointments = $paginator->paginate(
        // Consulta Doctrine, no resultados
            $shirts,
            // Definir el parámetro de la página
            $request->query->getInt('page', 1),
            // Items per page
            6
        );
        return $this->render('home.html.twig', [
            "shirts"=>$appointments,
            "categories"=>$categories
        ]);
    }
}
