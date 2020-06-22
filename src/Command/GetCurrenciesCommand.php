<?php


namespace App\Command;

use App\Controller\IndexController;
use App\Service\CurrencyService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class GetCurrenciesCommand extends Command
{
    protected static $defaultName = 'app:get-currencies';
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        parent::__construct();
        $this->currencyService = $currencyService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Get current currencies courses')
            ->setHelp('This command allows you to get current currencies courses');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln(['getting currencies...']);

        $this->currencyService->clearCurrencies();
        $data = $this->currencyService->collectCourses($this->currencyService->date);

        $output->writeln([ !empty($data) ? 'currencies was updated!' : 'currencies updating error!']);

        return 0;
    }
}