<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface as JWTManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DTOManager
{
    public function __construct(
        private JWTManager $jwtManager,
        private TokenStorageInterface $tokenStorageInterface,
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {
    }

    public function deserializeToDTO(string $DTOClass, string $content): mixed
    {
        return $this->serializer->deserialize($content, $DTOClass, 'json');
    }

    public function validateDTO(mixed $DTOObject): void
    {
        $errors = $this->validator->validate($DTOObject);
        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }
    }

    public function deserializeAndvalidateDTO(string $DTOClass, string $content): mixed
    {
        $DTOObject = $this->deserializeToDTO($DTOClass, $content);
        $this->validateDTO($DTOObject);

        return $DTOObject;
    }
}
