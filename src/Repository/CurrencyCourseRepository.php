<?php

namespace App\Repository;

use App\Entity\Currency;
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

        $qb = $this->createQueryBuilder('cc')
            ->select('c.numcode', 'c.charcode', 'c.name', 'cc.nominal', 'cc.value' )
            ->leftJoin(Currency::class, 'c', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.c_id = cc.c_id')
            ->where('cc.date = :date')
            ->setParameters([
                'date' => $date
            ]);
//            ->setMaxResults($limit)
//            ->setFirstResult($offset);

        $data['currencies'] = $qb->getQuery()
//            ->getSQL()
            ->getResult();

        $qb = $this->createQueryBuilder('cc')
            ->select('COUNT(cc.id)')
            ->where('cc.date = :date')
            ->setParameters([
                'date' => $date
            ]);

        $data['currencies_count'] = $qb->getQuery()
            ->getSingleScalarResult();

        if($data['currencies_count'] > 0) {
            $data['pages_count'] = ceil($data['currencies_count']/$per_page);
            $data['per_page'] = $per_page;
            $data['page'] = $page;
        }

        return $data;
    }


}
