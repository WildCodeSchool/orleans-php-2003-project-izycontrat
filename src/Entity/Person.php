<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(["int", "null"], message="Mauvais format de données")
     * @Assert\Range(
     *      min = 0,
     *      max = 2,
     *      notInRangeMessage = "Le Genre n'est pas valide",
     * )
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le Prénom doit contenir d'au moins {{ limit }} characters",
     *      maxMessage = "Le Prénom doit contenir au maximum {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Type(["string", "null"], message="Mauvais format de données")
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Le deuxième Prénom doit contenir au maximum {{ limit }} characters",
     *      allowEmptyString = true
     * )
     */
    private $middleName = null;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "Le Nom doit contenir d'au moins {{ limit }} characters",
     *      maxMessage = "Le Nom doit contenir au maximum {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\NotBlank(message="Le numéro de téléphone ne doit pas être vide")
     * @Assert\Regex(
     *     pattern="/^(\+33)?(0)?[0-9]{9}$/",
     *     match=false,
     *     message="Le numéro de téléphone doit être dans un format valide (+33XXXXXXXXX ou 0XXXXXXXXX)"
     * )
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string", message="Mauvais format de données")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "L'adresse doit contenir d'au moins {{ limit }} characters",
     *      maxMessage = "L'adresse doit contenir au maximum {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Type(["string", "null"], message="Mauvais format de données")
     * @Assert\Country(message="Ce n'est pas un pays valide")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le pays doit contenir au maximum {{ limit }} characters",
     *      allowEmptyString = true
     * )
     */
    private $country;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(["int", "null"], message="Mauvais format de données")
     * @Assert\Positive(message="Le Capital apporté ne peux pas être négatif")
     */
    private $capitalAmountAdding;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type(["bool", "null"], message="Mauvais format de données")
     */
    private $hasCompany;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): self
    {
        $this->gender = $gender;

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

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCapitalAmountAdding(): ?int
    {
        return $this->capitalAmountAdding;
    }

    public function setCapitalAmountAdding(?int $capitalAmountAdding): self
    {
        $this->capitalAmountAdding = $capitalAmountAdding;

        return $this;
    }

    public function getHasCompany(): ?bool
    {
        return $this->hasCompany;
    }

    public function setHasCompany(?bool $hasCompany): self
    {
        $this->hasCompany = $hasCompany;

        return $this;
    }
}
