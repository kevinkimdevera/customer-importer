<?php

namespace App\Command;

use App\Service\CustomerImporter;
use App\Service\CustomerImporterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:customers:clear',
    description: 'Clear all customers'
)]
class ClearCustomerCommand extends Command {

    private $customerImporter;

    public function __construct(CustomerImporterService $customerImporterService) {
        $this->customerImporter = $customerImporterService;

        parent::__construct();
    }

    protected function configure() : void {
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
      $helper = $this->getHelper('question');
      
      $question = new Question('Are you sure you want to clear all customers? (yes/no): ', 'no');

      $answer = $helper->ask($input, $output, $question);

      if ($answer === 'yes' || $answer === 'y') {
        $this->customerImporter->deleteAllCustomers();
        $output->writeln('All customers have been cleared.');
      } else {
        $output->writeln('Operation cancelled.');
      }

      return Command::SUCCESS;
    }
}