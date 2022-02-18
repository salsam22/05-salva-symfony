<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Shirt;
use App\Entity\User;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/basket")
 */
class BasketController extends AbstractController
{
    /**
     * @Route("/{id}", name="basket", methods={"GET"})
     */
    public function index(BasketRepository $basketRepository, User $user): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $baskets = $basketRepository->findBy(['user'=>$user->getId()]);
        return $this->render('basket/index.html.twig', [
            'baskets' => $baskets,
        ]);
    }

    /**
     * @Route("/add/{id}", name="basket_add", methods={"GET", "POST"})
     */
    public function add(Shirt $shirt, Request $request, EntityManagerInterface $entityManager): Response {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }

        $basket = new Basket();
        $basket->setUser($this->getUser());
        $basket->setShirt($shirt);
        $this->addFlash(
            'notice',
            'Shirt added to basket!'
        );
        $entityManager->persist($basket);
        $entityManager->flush();
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/{id}", name="basket_delete", methods={"POST"})
     */
    public function delete(Request $request, Basket $basket, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        if ($this->isCsrfTokenValid('delete'.$basket->getId(), $request->request->get('_token'))) {
            $entityManager->remove($basket);
            $entityManager->flush();
        }
        $this->addFlash(
            'notice',
            'Shirt deleted successfully from this basket!'
        );

        return $this->redirectToRoute('basket', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/send/{id}", name="basket_send", methods={"POST", "GET"})
     */
    public function send(BasketRepository $basketRepository, User $user, EntityManagerInterface $entityManager):Response {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $baskets = $basketRepository->findBy(['user'=>$user->getId()]);

        foreach ($baskets as $basket) {
            $entityManager->remove($basket);
        }

        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Purchase made correctly!'
        );
        //return $this->redirectToRoute('basket', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }


}
