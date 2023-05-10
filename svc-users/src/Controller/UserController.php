<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\HttpMessages;
use App\Enum\RoleEnum;
use App\Service\DTOManager;
use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
        private JWTManager $jwtManager,
        private UserManager $userManager,
        private DTOManager $dTOManager
    ) {
    }

    #[Route('/api/user/{id}', name: 'user-update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        if (!$this->userManager->hasRight($id)) {
            return new JsonResponse(['message' => HttpMessages::HTTP_UNAUTHORIZED], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $bodyContent = $request->getContent();
        $user = $this->userManager->updateCurrentUser($bodyContent);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['action' => "je suis le update"]);
    }

    #[Route('/api/user/{id}', name: 'user-delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        if (!$this->userManager->hasRight($id)) {
            return new JsonResponse(['message' => HttpMessages::HTTP_UNAUTHORIZED], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['action' => "je suis le delete"]);
    }

    #[Route('/api/user/{id}', name: 'user-get', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        if (!$this->userManager->hasRight($id)) {
            return new JsonResponse(['message' => HttpMessages::HTTP_UNAUTHORIZED], JsonResponse::HTTP_UNAUTHORIZED);
        }
        return new JsonResponse(['action' => "je suis le get"]);
    }
}
