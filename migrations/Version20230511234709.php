<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511234709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flower_item ADD flower_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE flower_item ADD CONSTRAINT FK_260AB2052C09D409 FOREIGN KEY (flower_id) REFERENCES flower (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_260AB2052C09D409 ON flower_item (flower_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE flower_item DROP CONSTRAINT FK_260AB2052C09D409');
        $this->addSql('DROP INDEX IDX_260AB2052C09D409');
        $this->addSql('ALTER TABLE flower_item DROP flower_id');
    }
}
