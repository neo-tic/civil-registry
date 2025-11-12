<?php

namespace App\Entity;

use App\Repository\CitizenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitizenRepository::class)]
#[ORM\UniqueConstraint(name: 'uq_citizen_nni', fields: ['nni'])]
#[ORM\HasLifecycleCallbacks]
class Citizen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private string $nni;

    #[ORM\Column(length: 120)]
    private string $firstNameFr;

    #[ORM\Column(length: 120)]
    private string $firstNameAr;

    #[ORM\Column(length: 120)]
    private string $lastNameFr;

    #[ORM\Column(length: 120)]
    private string $lastNameAr;

    #[ORM\Column(length: 20)]
    private string $genderFr;

    #[ORM\Column(length: 20)]
    private string $genderAr;

    #[ORM\Column(type: 'date_immutable')]
    private \DateTimeImmutable $dateOfBirth;

    #[ORM\Column(length: 255)]
    private string $placeOfBirthFr;

    #[ORM\Column(length: 255)]
    private string $placeOfBirthAr;

    #[ORM\Column(length: 80)]
    private string $maritalStatusFr;

    #[ORM\Column(length: 80)]
    private string $maritalStatusAr;

    #[ORM\Column(length: 120)]
    private string $nationalityFr;

    #[ORM\Column(length: 120)]
    private string $nationalityAr;

    #[ORM\Column(length: 255)]
    private string $addressFr;

    #[ORM\Column(length: 255)]
    private string $addressAr;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNni(): string
    {
        return $this->nni;
    }

    public function setNni(string $nni): self
    {
        $this->nni = $nni;

        return $this;
    }

    public function getFirstNameFr(): string
    {
        return $this->firstNameFr;
    }

    public function setFirstNameFr(string $firstNameFr): self
    {
        $this->firstNameFr = $firstNameFr;

        return $this;
    }

    public function getFirstNameAr(): string
    {
        return $this->firstNameAr;
    }

    public function setFirstNameAr(string $firstNameAr): self
    {
        $this->firstNameAr = $firstNameAr;

        return $this;
    }

    public function getLastNameFr(): string
    {
        return $this->lastNameFr;
    }

    public function setLastNameFr(string $lastNameFr): self
    {
        $this->lastNameFr = $lastNameFr;

        return $this;
    }

    public function getLastNameAr(): string
    {
        return $this->lastNameAr;
    }

    public function setLastNameAr(string $lastNameAr): self
    {
        $this->lastNameAr = $lastNameAr;

        return $this;
    }

    public function getGenderFr(): string
    {
        return $this->genderFr;
    }

    public function setGenderFr(string $genderFr): self
    {
        $this->genderFr = $genderFr;

        return $this;
    }

    public function getGenderAr(): string
    {
        return $this->genderAr;
    }

    public function setGenderAr(string $genderAr): self
    {
        $this->genderAr = $genderAr;

        return $this;
    }

    public function getDateOfBirth(): \DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeImmutable $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getPlaceOfBirthFr(): string
    {
        return $this->placeOfBirthFr;
    }

    public function setPlaceOfBirthFr(string $placeOfBirthFr): self
    {
        $this->placeOfBirthFr = $placeOfBirthFr;

        return $this;
    }

    public function getPlaceOfBirthAr(): string
    {
        return $this->placeOfBirthAr;
    }

    public function setPlaceOfBirthAr(string $placeOfBirthAr): self
    {
        $this->placeOfBirthAr = $placeOfBirthAr;

        return $this;
    }

    public function getMaritalStatusFr(): string
    {
        return $this->maritalStatusFr;
    }

    public function setMaritalStatusFr(string $maritalStatusFr): self
    {
        $this->maritalStatusFr = $maritalStatusFr;

        return $this;
    }

    public function getMaritalStatusAr(): string
    {
        return $this->maritalStatusAr;
    }

    public function setMaritalStatusAr(string $maritalStatusAr): self
    {
        $this->maritalStatusAr = $maritalStatusAr;

        return $this;
    }

    public function getNationalityFr(): string
    {
        return $this->nationalityFr;
    }

    public function setNationalityFr(string $nationalityFr): self
    {
        $this->nationalityFr = $nationalityFr;

        return $this;
    }

    public function getNationalityAr(): string
    {
        return $this->nationalityAr;
    }

    public function setNationalityAr(string $nationalityAr): self
    {
        $this->nationalityAr = $nationalityAr;

        return $this;
    }

    public function getAddressFr(): string
    {
        return $this->addressFr;
    }

    public function setAddressFr(string $addressFr): self
    {
        $this->addressFr = $addressFr;

        return $this;
    }

    public function getAddressAr(): string
    {
        return $this->addressAr;
    }

    public function setAddressAr(string $addressAr): self
    {
        $this->addressAr = $addressAr;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PreUpdate]
    public function refreshUpdatedAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
