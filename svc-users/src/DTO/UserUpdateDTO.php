<?php

namespace App\DTO;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;
use App\Enum\GenderEnum;
use DateTime;

class UserUpdateDTO extends AbstractDTO
{

    #[Assert\NotBlank]
    private ?string $firstName = null;

    #[Assert\NotBlank]
    private ?string $lastName = null;

    private ?GenderEnum $gender = null;

    #[CustomAssert\IsAdult]
    private ?DateTime $birthday = null;

    #[Assert\Url]
    private ?string $profilePicture = User::DEFAULT_PROFILE_PICTURE;

    #[Assert\Url]
    private ?string $coverPhoto = User::DEFAULT_COVER_PICTURE;

    #[Assert\Length(max: 600)]
    private ?string $biography = '';


    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastname(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }


    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function setGender(GenderEnum $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getBirthday(): DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(DateTime $birthday): self
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    public function getCoverPhoto(): string
    {
        return $this->coverPhoto;
    }

    public function setCoverPhoto(string $coverPhoto): self
    {
        $this->coverPhoto = $coverPhoto;
        return $this;
    }

    public function getBiography(): string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;
        return $this;
    }
}
