<?php

namespace App\Controller;

use App\Entity\Shirt;
use App\Entity\User;
use App\Form\ShirtType;
use App\Repository\ShirtRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shirt")
 */
class ShirtController extends AbstractController
{


    /**
     * @Route("/new", name="shirt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $shirt = new Shirt();
        $form = $this->createForm(ShirtType::class, $shirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shirt->setUser($this->getUser());
            $this->addFlash(
                'notice',
                'Shirt "' . $shirt->getTitle() . '" created successfully!'
            );
            $entityManager->persist($shirt);
            $entityManager->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shirt/new.html.twig', [
            'shirt' => $shirt,
            'form' => $form,
        ]);
    }

    /**
     * @Route ("/show/{id}", name="shirt_show")
     */
    public function show($id, ShirtRepository $shirtRepository, UserRepository $userRepository): Response {

        $shirt = $shirtRepository->find($id);
        return $this->render('shirt/shirt.html.twig', [
            'shirt' => $shirt,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="shirt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Shirt $shirt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ShirtType::class, $shirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($shirt->getImagesFile() == null) {
                $shirt->setImagesFile($shirt->getImage());
            }
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Shirt "' . $shirt->getTitle() . '" edited correctly!'
            );
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('shirt/edit.html.twig', [
            'shirt' => $shirt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="shirt_delete", methods={"POST"})
     */
    public function delete(Request $request, Shirt $shirt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shirt->getId(), $request->request->get('_token'))) {
            $entityManager->remove($shirt);
            $entityManager->flush();
        }
        $title = $shirt->getTitle();
        $this->addFlash(
            'notice',
            'Shirt "' . $title . '" deleted successfully!'
        );

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", name="shirt_index", methods={"GET"})
     */
    public function index(ShirtRepository $shirtRepository, Request $request, PaginatorInterface $paginator): Response {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $shirts = $shirtRepository->findByIdOrdered(["id"=>$this->getUser()->getId()]);
        return $this->render('shirt/index.html.twig', [
            'shirts' => $shirts
        ]);
    }
}
