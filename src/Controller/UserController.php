<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ShirtRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user, ShirtRepository $shirtRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $shirts = $shirtRepository->findByIdOrdered(["id"=>$user->getId()]);
        $appointments = $paginator->paginate(
        // Consulta Doctrine, no resultados
            $shirts,
            // Definir el parámetro de la página
            $request->query->getInt('page', 1),
            // Items per page
            6
        );
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'shirts' => $appointments
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'notice',
                'User "' . $user->getName() . '" edited correctly!'
            );
            $role = $this->getUser()->getRol();
            $user->setRol($role);
            $user->setPassword($user->getPassword());
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
