<?php

namespace App\Command;

use App\Service\CustomerImporterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:customers:import',
    description: 'Import customers from API url'
)]
class ImportCustomersCommand extends Command
{
    private $customerRepository;
    public function __construct(
        private CustomerImporterService $customerImporterService) {
        parent::__construct();
    }

    protected function configure() : void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        // Define the parameters to be passed to the API
        $params = [];

        $helper = $this->getHelper('question');

        // Ask to clear all customers before importing new ones
        $question = new Question('Do you want to clear all customers before importing new ones? (yes/no): ', 'no');
        $answer = $helper->ask($input, $output, $question);
        if ($answer === 'yes' || $answer === 'y') {
            $this->customerImporterService->deleteAllCustomers();
            $output->writeln('All customers have been cleared.');
        }

        // Ask for number of customers to import (default: 100)
        $question = new Question('Enter the number of customers to import (default: 100): ', 100);
        $params['results'] = $helper->ask($input, $output, $question);

        // // Ask for the nationality of the customers to import
        // $question = new Question('Enter the nationality of the customers to import (default: AU): ', 'AU');
        // $params['nat'] = $helper->ask($input, $output, $question);

        // Import customers from Australia
        $params['nat'] = 'AU';

        // Get customers from the API
        $output->writeln('Importing customers...');
        $imported_count = $this->customerImporterService->importCustomers($params);

        // Output the number of customers imported
        $output->writeln('Done importing ' . $imported_count . ' customers.');

        // Return Command::SUCCESS
        return Command::SUCCESS;
    }
}