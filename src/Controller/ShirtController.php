<?php

namespace App\Controller;

use App\Entity\Shirt;
use App\Form\ShirtType;
use App\Repository\ShirtRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $shirt = new Shirt();
        $form = $this->createForm(ShirtType::class, $shirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            $entityManager->flush();

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

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
