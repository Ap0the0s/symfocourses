<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\CurrencyCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Currency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currency[]    findAll()
 * @method Currency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    public function setCurrency($currency, $date){

        $em = $this->getEntityManager();

        $currency_obj = new Currency();
        $currency_obj->setCId($currency->getId());
        $currency_obj->setNumcode($currency->getNumcode());
        $currency_obj->setCharcode($currency->getCharcode());
        $currency_obj->setName($currency->getName());

        $em->persist($currency_obj);
        $em->flush();

        $currency_course = new CurrencyCourse();
        $currency_course->setCId($currency->getId());
        $currency_course->setNominal($currency->getNominal());
        $currency_course->setValue($currency->getValue());
        $currency_course->setDate(new \DateTime(date("Y-m-d",strtotime($date))));

        $em->persist($currency_course);
        $em->flush();
    }

}
