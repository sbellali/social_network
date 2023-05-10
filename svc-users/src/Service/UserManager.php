<?php
namespace App\Service;

use App\Entity\User;
use App\DTO\UserUpdateDTO;
use App\Enum\RoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface as JWTManager;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserManager
{

    public function __construct(
        private JWTManager $jwtManager,
        private TokenStorageInterface $tokenStorageInterface,
        private EntityManagerInterface $entityManager,
        private DTOManager $dTOManager,
        private WorkExperienceManager $workExperienceManager,
        private Security $security
    ) {
    }

    public function getCurrentUserId(): int|false
    {
        $token = $this->tokenStorageInterface->getToken();
        $decodedToken = $this->jwtManager->decode($token);
        if (!isset($decodedToken['id'])) {
            throw new Exception("Id not found");
        }
        return $decodedToken['id'];
    }

    public function getCurrentUser(): User
    {
        $id = $this->getCurrentUserId();
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw new Exception("No user found for id: $id");
        }
        return $user;
    }

    public function updateCurrentUser(string $data): User
    {
        $user = $this->getCurrentUser();
        $userUpdateDTO = $this->dTOManager->deserializeAndvalidateDTO(UserUpdateDTO::class, $data);
        $userUpdateDTO->fill($user);
        return $user;
    }

    public function hasRight(int $id): bool
    {
        return !($this->getCurrentUserId() !== $id && !$this->security->isGranted(RoleEnum::ROLE_ADMIN));
    }
}
