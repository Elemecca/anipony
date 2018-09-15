<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180915104321 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE licensor_product_work (
                licensor_product_id INT NOT NULL,
                work_id INT NOT NULL,
                PRIMARY KEY(licensor_product_id, work_id),
                INDEX IDX_5B243F4BB81B3354 (licensor_product_id),
                INDEX IDX_5B243F4BBB3453DB (work_id),
                CONSTRAINT FK_5B243F4BB81B3354
                    FOREIGN KEY (licensor_product_id)
                    REFERENCES licensor_product (id)
                    ON DELETE CASCADE,
                CONSTRAINT FK_5B243F4BBB3453DB
                    FOREIGN KEY (work_id)
                    REFERENCES work (id)
                    ON DELETE CASCADE
            ) ENGINE = InnoDB
        ');

        $this->addSql('ALTER TABLE licensor_product DROP FOREIGN KEY FK_3FCE81DABB3453DB');
        $this->addSql('DROP INDEX IDX_3FCE81DABB3453DB ON licensor_product');

        $this->addSql('
            INSERT INTO licensor_product_work (licensor_product_id, work_id)
            SELECT id, work_id
            FROM licensor_product
            WHERE work_id is not null
        ');

        $this->addSql('ALTER TABLE licensor_product DROP work_id');
    }

    public function down(Schema $schema) : void
    {
        $this->throwIrreversibleMigrationException();
    }
}
