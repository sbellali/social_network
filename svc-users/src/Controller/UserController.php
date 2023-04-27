<?php

namespace App\Controller;

use App\Entity\User;
use App\DTO\UserCreateDTO;
use App\Entity\UserCreateDTO as EntityUserCreateDTO;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse
    {
        $userCreateDTO =  $serializer->deserialize($request->getContent(), EntityUserCreateDTO::class, 'json');
        $errors = $validator->validate($userCreateDTO);
        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $user = new User();
        $userCreateDTO->fill($user);
        $user->setPassword($passwordHasher->hashPassword($user, $userCreateDTO->getPassword()));
        $entityManager->persist($user);
        $entityManager->flush();
        $token = $jwtManager->create($user);
        $serializedUser = $serializer->normalize($user, 'array');

        return new JsonResponse(['user' => $serializedUser, 'token' => $token], 201);
    }
}
