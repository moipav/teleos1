<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ln = null;

    #[ORM\Column(length: 255)]
    private ?string $fn = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    private ?Address $address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLn(): ?string
    {
        return $this->ln;
    }

    public function setLn(string $ln): static
    {
        $this->ln = $ln;

        return $this;
    }

    public function getFn(): ?string
    {
        return $this->fn;
    }

    public function setFn(string $fn): static
    {
        $this->fn = $fn;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }
}
