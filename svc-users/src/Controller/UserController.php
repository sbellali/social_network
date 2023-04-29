<?php

namespace App\Controller;

use App\Entity\User;
use App\DTO\UserCreateDTO;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface as JWTManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as PasswordHasher;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {}

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, PasswordHasher $passwordHasher, JWTManager $jwtManager): JsonResponse 
    {
        $userCreateDTO =  $this->serializer->deserialize($request->getContent(), UserCreateDTO::class, 'json');
        $errors = $this->validator->validate($userCreateDTO);
        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $user = new User();
        $userCreateDTO->fill($user);
        $user->setPassword($passwordHasher->hashPassword($user, $userCreateDTO->getPassword()));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $token = $jwtManager->create($user);
        $serializedUser = $this->serializer->normalize($user, 'array');

        return new JsonResponse(['user' => $serializedUser, 'token' => $token], 201);
    }

    #[Route('/user/{id}', name: 'updateUser', methods: ['PUT'])]
    public function modifyUser(Request $request, int $id)
    {
        $userModifyDTO =  $this->serializer->deserialize($request->getContent(), UserModifyDTO::class, 'json');
        $errors = $this->validator->validate($userModifyDTO);
        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }
        $user = $entityManager->getRepository(User::class)->find($id);
        dd($user);

    }
}
