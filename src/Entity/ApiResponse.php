<?php

namespace App\Entity;

use JMS\Serializer\Annotation as JMS;

/** @JMS\XmlRoot("ValCurs") */
class ApiResponse
{

    /**
     * @JMS\XmlAttribute
     * @JMS\Type("string")
     * @JMS\SerializedName("Date")
     */
    protected $date;

    /**
     * @JMS\XmlAttribute
     * @JMS\Type("string")
     * @JMS\SerializedName("name")
     */
    protected $name;

    /**
     * @JMS\Type("array<App\Entity\Valute>")
     * @JMS\XmlList(inline = true, entry = "Valute")
     */
    protected $currencies;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
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
    public function getCurrencies()
    {
        return $this->currencies;
    }

    /**
     * @param mixed $currencies
     */
    public function setCurrencies($currencies): void
    {
        $this->currencies = $currencies;
    }

}
