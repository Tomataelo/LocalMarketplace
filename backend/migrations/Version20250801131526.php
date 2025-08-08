<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250801131526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD province_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP province
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD CONSTRAINT FK_3B1CE6A3E946114A FOREIGN KEY (province_id) REFERENCES province (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3B1CE6A3E946114A ON customer_order (province_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP CONSTRAINT FK_3B1CE6A3E946114A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3B1CE6A3E946114A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD province VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP province_id
        SQL);
    }
}
