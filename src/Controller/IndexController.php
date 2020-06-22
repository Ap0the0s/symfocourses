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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {

        $data = $this->currencyService->getCurrenciesSlice();

        $page = $request->query->get('page') > 0 ?  $request->query->get('page') : 1;

        $pagination = $this->currencyService->paginator->paginate($data['currencies'], $page, 5);

        return $this->render('index.html.twig', [
            'pagination' => $pagination
        ]);
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