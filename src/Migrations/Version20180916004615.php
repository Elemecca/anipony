<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180916004615 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE review (
                id INT AUTO_INCREMENT NOT NULL,
                work_id INT NOT NULL,
                appropriate INT DEFAULT NULL,
                horrible INT DEFAULT NULL,
                summary LONGTEXT DEFAULT NULL,
                notes LONGTEXT DEFAULT NULL,
                english LONGTEXT DEFAULT NULL,
                tags LONGTEXT DEFAULT NULL,
                PRIMARY KEY(id),
                INDEX IDX_794381C6BB3453DB (work_id),
                CONSTRAINT FK_794381C6BB3453DB
                    FOREIGN KEY (work_id)
                    REFERENCES work (id)
            ) ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE review');
    }
}
