<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to main needs!
 */
final class Version20220116201037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to main needs
        $this->addSql('ALTER TABLE repo ADD org_id INT NOT NULL');
        $this->addSql('ALTER TABLE repo ADD CONSTRAINT FK_5C5CBBFFF4837C1B FOREIGN KEY (org_id) REFERENCES org (id)');
        $this->addSql('CREATE INDEX IDX_5C5CBBFFF4837C1B ON repo (org_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to main needs
        $this->addSql('ALTER TABLE repo DROP FOREIGN KEY FK_5C5CBBFFF4837C1B');
        $this->addSql('DROP INDEX IDX_5C5CBBFFF4837C1B ON repo');
        $this->addSql('ALTER TABLE repo DROP org_id');
    }
}
