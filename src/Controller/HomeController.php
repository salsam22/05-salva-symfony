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
        $categoriesValue = $categoryRepository->findAll();
        $filterCategory = $request->get("category");
        $startDate = $request->get("start_date");
        $endDate = $request->get("end_date");
        $searcher = $request->get("searcher");

        if (empty($startDate) || empty($endDate)) {
            if (empty($filterCategory)) {
                if (empty($searcher)) {
                    $shirts = $shirtRepository->orderByDate();
                } else {
                    $shirts = $shirtRepository->searchByWords($searcher);
                }
            } else {
                $shirts = $shirtRepository->findBy(["category"=>$filterCategory]);
            }
        } else {
            $shirts = $shirtRepository->filterDate($startDate, $endDate);
        }

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
            "categories"=>$categoriesValue
        ]);
    }
}
