<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180915172929 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE collection (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE collection_work (
                collection_id INT NOT NULL,
                work_id INT NOT NULL,
                PRIMARY KEY(collection_id, work_id),
                INDEX IDX_1939446E514956FD (collection_id),
                INDEX IDX_1939446EBB3453DB (work_id),
                CONSTRAINT FK_1939446E514956FD
                    FOREIGN KEY (collection_id)
                    REFERENCES collection (id) ON DELETE CASCADE,
                CONSTRAINT FK_1939446EBB3453DB
                    FOREIGN KEY (work_id)
                    REFERENCES work (id) ON DELETE CASCADE
            ) ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE collection_work');
        $this->addSql('DROP TABLE collection');
    }
}
