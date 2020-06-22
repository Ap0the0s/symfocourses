<?php


namespace App\Entity;

use JMS\Serializer\Annotation as JMS;

class Valute
{

    /**
     * @JMS\XmlAttribute
     * @JMS\Type("string")
     * @JMS\SerializedName("ID")
     */
    protected $id;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("NumCode")
     */
    protected $numcode;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("CharCode")
     */
    protected $charcode;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Nominal")
     */
    protected $nominal;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Name")
     */
    protected $name;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Value")
     */
    protected $value;

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
    public function getNominal()
    {
        return $this->nominal;
    }

    /**
     * @param mixed $nominal
     */
    public function setNominal($nominal): void
    {
        $this->nominal = $nominal;
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

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

}