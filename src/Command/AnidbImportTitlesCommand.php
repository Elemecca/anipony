<?php
/**
 *
 */

namespace App\Command;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnidbImportTitlesCommand
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
            ->setName('anidb:import:titles')
            ->addArgument('file', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = fopen($input->getArgument('file'), 'r');

        $stmt = $this->conn->prepare('
            insert into anidb_title set
              ani_id = :id, type = :type, lang = :lang, title = :title
        ');

        $id = null;
        $stmt->bindParam(':id', $id, ParameterType::INTEGER);

        $type = null;
        $stmt->bindParam(':type', $type);
        $types = [
            1 => 'main',
            2 => 'syn',
            3 => 'short',
            4 => 'official',
        ];

        $lang = null;
        $stmt->bindParam(':lang', $lang);

        $title = null;
        $stmt->bindParam(':title', $title);


        while (!feof($file)) {
            $line = fgets($file);
            if ($line === false) {
                throw new \RuntimeException("error reading input file");
            }

            if ($line[0] == '#') {
                continue;
            }

            list($id, $typeId, $lang, $title) = explode('|', $line, 4);
            $type = $types[$typeId];
            $stmt->execute();
        }

        fclose($file);
    }

}
