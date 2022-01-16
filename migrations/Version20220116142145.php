<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116142145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE repos (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, create_date VARCHAR(100) NOT NULL, link VARCHAR(100) NOT NULL, stars INT DEFAULT NULL, pulls_size INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organisation ADD repos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE organisation ADD CONSTRAINT FK_E6E132B4A213D4CB FOREIGN KEY (repos_id) REFERENCES repos (id)');
        $this->addSql('CREATE INDEX IDX_E6E132B4A213D4CB ON organisation (repos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE organisation DROP FOREIGN KEY FK_E6E132B4A213D4CB');
        $this->addSql('DROP TABLE repos');
        $this->addSql('DROP INDEX IDX_E6E132B4A213D4CB ON organisation');
        $this->addSql('ALTER TABLE organisation DROP repos_id');
    }
}
