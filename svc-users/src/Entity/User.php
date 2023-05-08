<?php

namespace App\Entity;

use DateTime;
use App\Repository\UserRepository;
use App\Enum\GenderEnum;
use App\Validator as CustomAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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


    #[ORM\OneToMany(targetEntity: "WorkExperience", mappedBy: "user")]
    private $workExperiences;


    #[ORM\OneToMany(targetEntity: "Education", mappedBy: "user")]
    private $educations;


    #[ORM\OneToMany(targetEntity: "PrivacySetting", mappedBy: "user")]
    private $privacySettings;

    // #[ORM\Column(type: "array")]
    // private array $followerRelationships;

    // #[ORM\Column(type: "array")]
    // private array $followingRelationships;


    public function __construct()
    {
        $this->workExperiences = new ArrayCollection();
        $this->educations = new ArrayCollection();
        $this->privacySettings = new ArrayCollection();
        // $this->followerRelationships = [];
        // $this->followingRelationships = [];
    }


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

    /**
     * @return Collection|WorkExperience[]
     */
    public function getWorkExperiences(): Collection
    {
        return $this->workExperiences;
    }

    public function addWorkExperience(WorkExperience $workExperience): self
    {
        if (!$this->workExperiences->contains($workExperience)) {
            $this->workExperiences[] = $workExperience;
        }

        return $this;
    }

    public function removeWorkExperience(WorkExperience $workExperience): self
    {
        $this->workExperiences->removeElement($workExperience);

        return $this;
    }

    /**
     * @return Collection|Education[]
     */
    public function getEducations(): Collection
    {
        return $this->educations;
    }

    public function addEducation(Education $education): self
    {
        if (!$this->educations->contains($education)) {
            $this->educations[] = $education;
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        $this->educations->removeElement($education);

        return $this;
    }

    /**
     * @return Collection|PrivacySetting[]
     */
    public function getPrivacySettings(): Collection
    {
        return $this->privacySettings;
    }

    public function addPrivacySetting(PrivacySetting $privacySetting): self
    {
        if (!$this->privacySettings->contains($privacySetting)) {
            $this->privacySettings[] = $privacySetting;
        }

        return $this;
    }

    public function removePrivacySetting(PrivacySetting $privacySetting): self
    {
        $this->privacySettings->removeElement($privacySetting);

        return $this;
    }
    // public function getFollowingRelationships(): array
    // {
    //     return $this->followingRelationships;
    // }

    // public function setFollowingRelationships(array $followingRelationships): self
    // {
    //     $this->followingRelationships = $followingRelationships;
    //     return $this;
    // }
}
