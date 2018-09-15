<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180915071231 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE anidb_title (
                id INT AUTO_INCREMENT NOT NULL,
                ani_id INT NOT NULL,
                type VARCHAR(50) NOT NULL,
                lang VARCHAR(50) NOT NULL,
                title VARCHAR(255) NOT NULL,
                PRIMARY KEY(id),
                FULLTEXT INDEX IDX_9D773DF12B36786B (title)
            ) ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE anidb_title');
    }
}
