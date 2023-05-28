<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230511192203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flower_item DROP CONSTRAINT fk_260ab2052c09d409');
        $this->addSql('DROP INDEX uniq_260ab2052c09d409');
        $this->addSql('ALTER TABLE flower_item DROP flower_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE flower_item ADD flower_id INT NOT NULL');
        $this->addSql('ALTER TABLE flower_item ADD CONSTRAINT fk_260ab2052c09d409 FOREIGN KEY (flower_id) REFERENCES flower (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_260ab2052c09d409 ON flower_item (flower_id)');
    }
}
