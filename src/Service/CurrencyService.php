<?php


namespace App\Service;


use App\Entity\ApiResponse;
use App\Entity\Currency;
use App\Entity\CurrencyCourse;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyService
{

    private $api_url = 'http://www.cbr.ru/scripts/XML_daily.asp';
    private $em;
    public $date;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
        $this->date = self::getDate();
    }

    public function getCurrenciesSlice($page = 1, $per_page = 5) {

        //проверяем курсы за сегодня по дефолту или за указанную дату в базе
        $check_currencies = $this->em->getRepository(CurrencyCourse::class)
            ->getCurrencies($this->date, $page, $per_page);

        //отображаем если есть, собираем и записываем, если нет
        return !empty($check_currencies['currencies']) ? $check_currencies : $this->collectCourses($this->date);
    }

    //TODO: get data from api
    public  function collectCourses($date) {
        $data = [];
        $parsed_data = [];

        $url = !$this->date ? $this->api_url : $this->api_url."?date_req=".$this->date;
        $raw_data = file_get_contents($url);

        // парсим обычными методами PHP
        $xml = simplexml_load_string($raw_data); // default parsing
        $parsed_data = json_decode(json_encode($xml),true); // default parsing

        // парсим через JMS Serializer
//        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
//        $parsed_data = $serializer->deserialize($raw_data, ApiResponse::class,'xml');

//        dd($parsed_data); exit;

        if(!empty($parsed_data) && !empty($parsed_data['Valute'])) {

            foreach ($parsed_data['Valute'] as $currency) {
                $this->em->getRepository(Currency::class)
                    ->setCurrencies($currency, $date);
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

    public static function getDate($date = false)
    {
        return $date == false ? date("d.m.Y", $_SERVER['REQUEST_TIME']) : date("d.m.Y", $date);
    }
}