<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250728150034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create province table and insert provinces';
    }

    public function up(Schema $schema): void
    {
        // Tworzenie tabeli 'province'
        $this->addSql('CREATE TABLE province (id SERIAL NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');

        // Wstawienie danych do tabeli 'province'
        $this->addSql("INSERT INTO province (name) VALUES
            ('Dolnośląskie'),
            ('Kujawsko-Pomorskie'),
            ('Lubelskie'),
            ('Lubuskie'),
            ('Łódzkie'),
            ('Małopolskie'),
            ('Mazowieckie'),
            ('Opolskie'),
            ('Podkarpackie'),
            ('Podlaskie'),
            ('Pomorskie'),
            ('Śląskie'),
            ('Świętokrzyskie'),
            ('Warmińsko-Mazurskie'),
            ('Wielkopolskie'),
            ('Zachodniopomorskie')");
    }

    public function down(Schema $schema): void
    {
        // Usunięcie tabeli 'province'
        $this->addSql('DROP TABLE province');
    }
}
