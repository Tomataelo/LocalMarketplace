<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250728144245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service ALTER contractor_id DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service ALTER category_id DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service ADD CONSTRAINT FK_8DCF8195B0265DC7 FOREIGN KEY (contractor_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service ADD CONSTRAINT FK_8DCF819512469DE2 FOREIGN KEY (category_id) REFERENCES service_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8DCF819512469DE2 ON contractor_service (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_contractor_id ON contractor_service (contractor_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD city VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD address VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD postal_code VARCHAR(15) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD province VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ALTER client_id DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ALTER category_id DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD CONSTRAINT FK_3B1CE6A319EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD CONSTRAINT FK_3B1CE6A312469DE2 FOREIGN KEY (category_id) REFERENCES service_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3B1CE6A312469DE2 ON customer_order (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_client_id ON customer_order (client_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP CONSTRAINT FK_3B1CE6A319EB6921
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP CONSTRAINT FK_3B1CE6A312469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3B1CE6A312469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_client_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP city
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP address
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP postal_code
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP province
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ALTER client_id SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ALTER category_id SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service DROP CONSTRAINT FK_8DCF8195B0265DC7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service DROP CONSTRAINT FK_8DCF819512469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8DCF819512469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_contractor_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service ALTER contractor_id SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service ALTER category_id SET NOT NULL
        SQL);
    }
}
