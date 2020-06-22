<?php

namespace App\Controller;

use App\Service\CurrencyService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class IndexController extends AbstractController
{

    private $currencyService;

    public function __construct(CurrencyService $currencyService){
        $this->currencyService = $currencyService;
    }

    /**
     * @Route("/", name="main", methods={"GET"})
     */
    public function index() {
        $currencies = $this->currencyService->getCurrenciesSlice();

        return $this->render('index.html.twig',
            [
                'currencies' => $currencies['currencies'],
                'currencies_count'=> $currencies['currencies_count'],
                'pages_count'=> $currencies['pages_count'],
                'per_page'=> $currencies['per_page'],
                'page' => $currencies['page']
            ]
        );
    }

    /**
     * @Route("/", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function page(Request $request) {

        $table = "";
        $page = $request->request->get('page');
        $per_page = $request->request->get('per_page');

        $data = $this->currencyService->getCurrenciesSlice($page, $per_page);

        if(isset($data['currencies']))
            $table = $this->renderView('table.html.twig',
                [
                    'currencies' => $data['currencies']
                ]
            );

        return new Response($table);
    }
}