<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 */
class Currency
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="string", length=50)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $numcode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $charcode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumcode(): ?string
    {
        return $this->numcode;
    }

    public function setNumcode(string $numcode): self
    {
        $this->numcode = $numcode;

        return $this;
    }

    public function getCharcode(): ?string
    {
        return $this->charcode;
    }

    public function setCharcode(string $charcode): self
    {
        $this->charcode = $charcode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
