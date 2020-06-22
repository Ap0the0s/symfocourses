<?php

namespace App\Repository;

use App\Entity\CurrencyCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @method CurrencyCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method CurrencyCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method CurrencyCourse[]    findAll()
 * @method CurrencyCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrencyCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyCourse::class);
    }

    public function getCurrencies($date, $page = 1, $per_page = 5){
        $data = [];

        $page = $page > 0 ? $page : 1;
        $per_page = $per_page > 0 ? $per_page : 5;
        $limit = abs((int)$per_page);
        $offset = ($page - 1) > 0 ? ($page - 1) * $per_page : 0;
        $date = date("Y-m-d", strtotime($date));

        $connection = $this->getEntityManager()->getConnection();

        $stmt = $connection->prepare("SELECT SQL_CALC_FOUND_ROWS c.*, cc.nominal, cc.value
                  FROM `currency_course` cc, `currency` c
                  WHERE cc.`c_id` = c.`id` AND `date` = :date LIMIT :offset, :limit");
        $stmt->bindValue('date', $date, PDO::PARAM_STR);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit,PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount()) {
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) != false) {
                $data['currencies'][] = $row;
            }
        }

        $stmt = $connection->prepare("SELECT FOUND_ROWS() as `count`");

        if($stmt->execute()) {
            $data['currencies_count'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            $data['pages_count'] = ceil($data['currencies_count']/$per_page);
            $data['per_page'] = $per_page;
            $data['page'] = $page;
        }

        return $data;
    }


}
