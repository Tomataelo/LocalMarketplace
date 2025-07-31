<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250728141127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD city VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD address VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD postal_code VARCHAR(15) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD province VARCHAR(100) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP location_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" ADD location_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP city
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP address
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP postal_code
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE "user" DROP province
        SQL);
    }
}
