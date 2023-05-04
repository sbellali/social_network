<?php

namespace App\Entity;

use DateTime;
use App\Repository\UserRepository;
use App\Enum\GenderEnum;
use App\Validator as CustomAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    const DEFAULT_PROFILE_PICTURE = "https://hostname/images/profile";
    const DEFAULT_COVER_PICTURE = "https://hostname/images/profile";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\Column(type: 'array')]
    #[CustomAssert\ContainsRoles]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Ignore]
    private ?string $password = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    private ?string $firstName = '';

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
    private ?string $lastName = '';

    #[ORM\Column(type: "string", enumType: GenderEnum::class)]
    private ?GenderEnum $gender = null;

    #[ORM\Column(type: "datetime")]
    private ?DateTime $birthday = null;

    #[ORM\Column(length: 255)]
    #[Assert\Url]
    private ?string $profilePicture = self::DEFAULT_PROFILE_PICTURE;

    #[ORM\Column(length: 255)]
    #[Assert\Url]
    private ?string $coverPhoto = self::DEFAULT_COVER_PICTURE;

    #[ORM\Column(type: "text")]
    #[Assert\Length(max: 600)]
    private ?string $biography = '';


    // #[ORM\OneToMany(targetEntity: "WorkExperience", mappedBy: "user")]
    // private $workExperience;


    // #[ORM\OneToMany(targetEntity: "Education", mappedBy: "user")]
    // private $education;


    // #[ORM\OneToMany(targetEntity: "SocialConnection", mappedBy: "user")]
    // private $socialConnections;


    // #[ORM\OneToMany(targetEntity: "PrivacySetting", mappedBy: "user")]
    // private $privacySettings;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_unique($roles);

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

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


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    #[Ignore]
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
