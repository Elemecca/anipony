<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180915090242 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE licensor_product (
                id INT AUTO_INCREMENT NOT NULL,
                licensor_id INT NOT NULL,
                work_id INT DEFAULT NULL,
                sku VARCHAR(50) DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                INDEX IDX_3FCE81DAF4355569 (licensor_id),
                INDEX IDX_3FCE81DABB3453DB (work_id),
                UNIQUE INDEX UNIQ_3FCE81DAF4355569F9038C4 (licensor_id, sku),
                PRIMARY KEY(id)
            ) ENGINE = InnoDB
        ');

        $this->addSql('
            CREATE TABLE licensor (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) ENGINE = InnoDB
        ');

        $this->addSql('
            CREATE TABLE work (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) ENGINE = InnoDB
        ');

        $this->addSql('
            ALTER TABLE licensor_product
                ADD CONSTRAINT FK_3FCE81DAF4355569
                    FOREIGN KEY (licensor_id) REFERENCES licensor (id),
                ADD CONSTRAINT FK_3FCE81DABB3453DB
                     FOREIGN KEY (work_id) REFERENCES work (id)
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE licensor_product DROP FOREIGN KEY FK_3FCE81DAF4355569');
        $this->addSql('ALTER TABLE licensor_product DROP FOREIGN KEY FK_3FCE81DABB3453DB');
        $this->addSql('DROP TABLE licensor_product');
        $this->addSql('DROP TABLE licensor');
        $this->addSql('DROP TABLE work');
    }
}
