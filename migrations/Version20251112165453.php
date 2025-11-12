<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251112165453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE citizen (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nni VARCHAR(10) NOT NULL, first_name_fr VARCHAR(120) NOT NULL, first_name_ar VARCHAR(120) NOT NULL, last_name_fr VARCHAR(120) NOT NULL, last_name_ar VARCHAR(120) NOT NULL, gender_fr VARCHAR(20) NOT NULL, gender_ar VARCHAR(20) NOT NULL, date_of_birth DATE NOT NULL --(DC2Type:date_immutable)
        , place_of_birth_fr VARCHAR(255) NOT NULL, place_of_birth_ar VARCHAR(255) NOT NULL, marital_status_fr VARCHAR(80) NOT NULL, marital_status_ar VARCHAR(80) NOT NULL, nationality_fr VARCHAR(120) NOT NULL, nationality_ar VARCHAR(120) NOT NULL, address_fr VARCHAR(255) NOT NULL, address_ar VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE UNIQUE INDEX uq_citizen_nni ON citizen (nni)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE citizen');
    }
}
