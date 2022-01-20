<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120180616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE org (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) DEFAULT NULL, link VARCHAR(100) DEFAULT NULL, provider VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repo (id INT AUTO_INCREMENT NOT NULL, org_id INT NOT NULL, name VARCHAR(100) DEFAULT NULL, create_date DATE DEFAULT NULL, link VARCHAR(100) DEFAULT NULL, stars INT DEFAULT NULL, pulls INT DEFAULT NULL, points DOUBLE PRECISION DEFAULT NULL, commits INT DEFAULT NULL, INDEX IDX_5C5CBBFFF4837C1B (org_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repo ADD CONSTRAINT FK_5C5CBBFFF4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repo DROP FOREIGN KEY FK_5C5CBBFFF4837C1B');
        $this->addSql('DROP TABLE org');
        $this->addSql('DROP TABLE repo');
    }
}
