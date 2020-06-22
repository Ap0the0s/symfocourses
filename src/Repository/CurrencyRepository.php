<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

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

    public function setCurrencies($currency, $date){

        $data['id'] = $currency['@attributes']['ID'];
        $data['numcode'] = $currency['NumCode'];
        $data['charcode'] = $currency['CharCode'];
        $data['nominal'] = $currency['Nominal'];
        $data['name'] = $currency['Name'];
        $data['value'] = $currency['Value'];

        $connection = $this->getEntityManager()->getConnection();

        $stmt = $connection->prepare("INSERT INTO currency(`id`,`numcode`,`charcode`,`name`)
                      VALUES (:id, :numcode, :charcode, :name)
                      ON DUPLICATE KEY 
                      UPDATE 
                      `numcode` = VALUES(`numcode`),
                      `charcode` = VALUES(`charcode`),
                      `name` = VALUES(`name`)
                      ");
        $stmt->bindValue('id', $data['id'], PDO::PARAM_STR);
        $stmt->bindValue('numcode', $data['numcode'], PDO::PARAM_STR);
        $stmt->bindValue('charcode', $data['charcode'], PDO::PARAM_STR);
        $stmt->bindValue('name', $data['name'], PDO::PARAM_STR);
        $stmt->execute();

        $date_format = date("Y-m-d",strtotime($date));

        $stmt = $connection->prepare("INSERT INTO currency_course (`c_id`,`nominal`,`value`,`date`)
                      VALUES (:id, :nominal, :value, :date)
                      ON DUPLICATE KEY 
                      UPDATE
                      `c_id` = VALUES(`c_id`),
                      `nominal` = VALUES(`nominal`),
                      `value` = VALUES(`value`)
                      ");

        $stmt->bindValue('id', $data['id'], PDO::PARAM_STR);
        $stmt->bindValue('nominal', $data['nominal'], PDO::PARAM_INT);
        $stmt->bindValue('value', $data['value'], PDO::PARAM_STR);
        $stmt->bindValue('date', $date_format, PDO::PARAM_STR);
        $stmt->execute();
    }

}
