<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

class UserModifyDTO
{
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[Assert\NotBlank]
    private ?string $username = null;


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function fill(User $user)
    {
        $user->setEmail($this->getEmail());
        $user->setUsername($this->getUsername());
    }

    public function extract(User $user)
    {
        $this->setEmail($user->getEmail());
        $this->setUsername($user->getUsername());
    }
}