<?php
namespace App\Controller;

use App\Entity\Message;
use App\Entity\MessageType;
use App\Model\MessageDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    public function list(
        EntityManagerInterface $entityManager,
        #[MapQueryParameter] ?int $offset,
        #[MapQueryParameter] ?int $limit
    ): JsonResponse
    {
        $messages = $entityManager->getRepository(Message::class)->findAll();
        return $this->json(['messages' => $messages], 200, [], ['groups' => ['main']]);
    }

    public function store(
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse
    {
        if (
            !$request->get('type_id') ||
            !$request->get('subject') ||
            !$request->get('content') ||
            !$request->get('sender')
        ) {
            return $this->json(['error' => 'Missing field'], 400);
        }
        $type = $entityManager->getRepository(MessageType::class)->find($request->get('type_id'));
        $entity = 'App\Entity\\'.ucfirst($type->getType()).'Message';
        $message = new $entity();
        $message->setType($type);
        $message->setSubject($request->get('subject'));
        $message->setContent($request->get('content'));
        $message->setSender($request->get('sender'));
        $message->setDate(new \DateTime());
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->json(['message' => $message], 200, [], ['groups' => ['main']]);
    }

    public function show(
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse
    {
        $id = $request->get('id');
        $message = $entityManager->getRepository(Message::class)->find($id);
        return $this->json(['message' => $message], 200, [], ['groups' => ['main']]);
    }

    public function update(
        EntityManagerInterface $entityManager,
        Request $request,
    ): JsonResponse
    {
        if (
            !$request->get('id') ||
            !$request->get('subject') ||
            !$request->get('content') ||
            !$request->get('sender')
        ) {
            return $this->json(['error' => 'Missing field'], 400);
        }
        $id = $request->get('id');
        $message = $entityManager->getRepository(Message::class)->find($id);
        $message->setSubject($request->get('subject'));
        $message->setContent($request->get('content'));
        $message->setSender($request->get('sender'));
        return $this->json(['message' => $message], 200, [], ['groups' => ['main']]);
    }

    public function delete(
        EntityManagerInterface $entityManager,
        Request $request
    ): JsonResponse
    {
        $id = $request->get('id');
        $message = $entityManager->getRepository(Message::class)->find($id);
        $entityManager->remove($message);
        $entityManager->flush();
        return $this->json(['succes' => 'Message deleted']);
    }
}