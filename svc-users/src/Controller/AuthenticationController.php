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

class AuthenticationController extends AbstractController
{
    function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private JWTManager $jwtManager
    ) {
    }

    #[Route('/api/register', name: 'register', methods: ['POST'])]
    public function register(Request $request, PasswordHasher $passwordHasher): JsonResponse
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
        $token = $this->jwtManager->create($user);
        $serializedUser = $this->serializer->normalize($user, 'array');

        return new JsonResponse(['user' => $serializedUser, 'token' => $token], 201);
    }

    #[Route('/api/health', name: 'health', methods: ['POSt'])]
    public function test(Request $request): JsonResponse
    {
        $user =  $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user->setPassword('password');
        $user->setRoles(array('ROLE_USER'));
        // $user->setBirthday(new \DateTime('1992-08-06'));
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }
        // dd($user);
        // $this->entityManager->persist($user);
        // $this->entityManager->flush();

        // $user = $this->entityManager->getRepository(User::class)->find(2);
        dd($user);
        return new JsonResponse([]);
    }
}
