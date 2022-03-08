<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307092124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE org_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE repo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE org (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE repo (id INT NOT NULL, org_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, create_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, link VARCHAR(255) NOT NULL, pulls INT NOT NULL, commits INT NOT NULL, provider VARCHAR(255) NOT NULL, points DOUBLE PRECISION DEFAULT NULL, stars INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5C5CBBFFF4837C1B ON repo (org_id)');
        $this->addSql('ALTER TABLE repo ADD CONSTRAINT FK_5C5CBBFFF4837C1B FOREIGN KEY (org_id) REFERENCES org (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE repo DROP CONSTRAINT FK_5C5CBBFFF4837C1B');
        $this->addSql('DROP SEQUENCE org_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE repo_id_seq CASCADE');
        $this->addSql('DROP TABLE org');
        $this->addSql('DROP TABLE repo');
    }
}
