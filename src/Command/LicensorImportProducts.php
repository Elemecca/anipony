<?php

namespace App\Command;


use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LicensorImportProducts
extends Command
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('import:licensor:catalog')
            ->addOption('licensor', 'l', InputOption::VALUE_REQUIRED)
            ->addArgument('file', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $licId = (int) $input->getOption('licensor');
        $file = fopen($input->getArgument('file'), 'r');

        $sku = null;
        $title = null;
        $stmt = $this->conn->prepare('
            replace into licensor_product set
                licensor_id = :lic_id, sku = :sku, title = :title
        ');
        $stmt->bindParam(':lic_id', $licId);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':title', $title);

        while (list($sku, $title) = fgetcsv($file)) {
            $stmt->execute();
        }

        fclose($file);
    }

}
