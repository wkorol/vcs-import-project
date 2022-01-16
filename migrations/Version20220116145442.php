<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116145442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE points');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE points (id INT AUTO_INCREMENT NOT NULL, repo_id INT NOT NULL, points INT NOT NULL, UNIQUE INDEX UNIQ_27BA8E29BD359B2D (repo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE points ADD CONSTRAINT FK_27BA8E29BD359B2D FOREIGN KEY (repo_id) REFERENCES repos (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
