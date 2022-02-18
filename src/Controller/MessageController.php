<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/view/{id}", name="message_index", methods={"GET"})
     */
    public function index(MessageRepository $messageRepository, User $user): Response
    {
        $sended = $messageRepository->findBy(['transmitter'=>$user]);
        $received = $messageRepository->findBy(['receiver'=>$user]);
        return $this->render('message/index.html.twig', [
            'sended' => $sended,
            'received' => $received,
        ]);
    }

    /**
     * @Route("/new/{id}", name="message_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, User $receiver): Response
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        }
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'notice',
                'Message created successfully!'
            );
            $message->setTransmitter($this->getUser());
            $message->setReceiver($receiver);
            $message->setDate();

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('user_show', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $this->addFlash(
                'notice',
                'Message deleted successfully!'
            );
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_show', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);
    }
}
