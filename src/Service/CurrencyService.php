<?php


namespace App\Service;


use App\Entity\ApiResponse;
use App\Entity\Currency;
use App\Entity\CurrencyCourse;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class CurrencyService
{

    private $api_url = 'http://www.cbr.ru/scripts/XML_daily.asp';
    private $em;
    public $paginator;
    public $date;

    public function __construct(EntityManagerInterface $em, PaginatorInterface $paginator){
        $this->em = $em;
        $this->paginator = $paginator;
        $this->date = self::getDate();
    }

    public function getCurrenciesSlice($page = 1, $per_page = 5) {

        //проверяем курсы за сегодня по дефолту или за указанную дату в базе
        $check_currencies = $this->em->getRepository(CurrencyCourse::class)
            ->getCurrencies($this->date, $page, $per_page);

        //отображаем если есть, собираем и записываем, если нет
        return !empty($check_currencies['currencies']) ? $check_currencies : $this->collectCourses($this->date);
    }

    public  function collectCourses($date) {
        $data = [];
        $parsed_data = [];

        $url = !$this->date ? $this->api_url : $this->api_url."?date_req=".$this->date;
        $raw_data = file_get_contents($url);

        // парсим через JMS Serializer
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $parsed_data = $serializer->deserialize($raw_data, ApiResponse::class,'xml');

        if(!empty($parsed_data)) {

            $currencies = $parsed_data->getCurrencies();

            foreach ($currencies as $currency) {
                $this->em->getRepository(Currency::class)
                    ->setCurrency($currency, $date);
            }

            $data = $this->getCurrenciesSlice();
        }

        return $data;
    }

    public function clearCurrencies() {
        $connection = $this->em->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('currency', true));
        $connection->executeUpdate($platform->getTruncateTableSQL('currency_course', true));
    }

    public static function getDate($date = false) {
        return $date == false ? date("d.m.Y", $_SERVER['REQUEST_TIME']) : date("d.m.Y", $date);
    }
}