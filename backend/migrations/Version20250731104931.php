<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250731104931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service DROP CONSTRAINT fk_8dcf819512469de2
        SQL);
                $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP CONSTRAINT fk_3b1ce6a312469de2
        SQL);

                $this->addSql(<<<'SQL'
            DROP TABLE service_category
        SQL);

                $this->addSql(<<<'SQL'
            CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);

                $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service ADD CONSTRAINT fk_8dcf819512469de2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
                $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD CONSTRAINT fk_3b1ce6a312469de2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service DROP CONSTRAINT FK_8DCF819512469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP CONSTRAINT FK_3B1CE6A312469DE2
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE service_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service_category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service DROP CONSTRAINT fk_8dcf819512469de2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE contractor_service ADD CONSTRAINT fk_8dcf819512469de2 FOREIGN KEY (category_id) REFERENCES service_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order DROP CONSTRAINT fk_3b1ce6a312469de2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE customer_order ADD CONSTRAINT fk_3b1ce6a312469de2 FOREIGN KEY (category_id) REFERENCES service_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }
}
