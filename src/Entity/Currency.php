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
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $c_id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $numcode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $charcode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCId()
    {
        return $this->c_id;
    }

    /**
     * @param mixed $c_id
     */
    public function setCId($c_id): void
    {
        $this->c_id = $c_id;
    }

    /**
     * @return mixed
     */
    public function getNumcode()
    {
        return $this->numcode;
    }

    /**
     * @param mixed $numcode
     */
    public function setNumcode($numcode): void
    {
        $this->numcode = $numcode;
    }

    /**
     * @return mixed
     */
    public function getCharcode()
    {
        return $this->charcode;
    }

    /**
     * @param mixed $charcode
     */
    public function setCharcode($charcode): void
    {
        $this->charcode = $charcode;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

}
