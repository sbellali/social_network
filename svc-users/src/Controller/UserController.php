<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface as JWTManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private JWTManager $jwtManager
    ) {
    }

    #[Route('/api/user/{id}', name: 'user-update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $user =  $this->serializer->deserialize($request->getContent(), User::class, 'json');

        dd($user);
        return new JsonResponse(['action' => "je suis le update"]);
    }

    #[Route('/api/user/{id}', name: 'user-delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return new JsonResponse(['action' => "je suis le delete"]);
    }

    #[Route('/api/user/{id}', name: 'user-get', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        dd($user->getWorkExperience());
        return new JsonResponse(['action' => "je suis le get"]);
    }
}
