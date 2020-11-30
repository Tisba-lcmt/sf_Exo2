<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201130131733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE content content LONGTEXT DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE publication_date publication_date DATETIME DEFAULT NULL, CHANGE creation_date creation_date DATETIME DEFAULT NULL, CHANGE is_published is_published TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE category CHANGE color color VARCHAR(255) DEFAULT NULL, CHANGE publication_date publication_date DATETIME DEFAULT NULL, CHANGE creation_date creation_date DATETIME DEFAULT NULL, CHANGE is_published is_published TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE content content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE publication_date publication_date DATETIME NOT NULL, CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE is_published is_published TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE color color VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE publication_date publication_date DATETIME NOT NULL, CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE is_published is_published TINYINT(1) NOT NULL');
    }
}
