<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230325143929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE flower_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE flower_item (id INT NOT NULL, flower_id INT NOT NULL, bouquet_id INT DEFAULT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_260AB2052C09D409 ON flower_item (flower_id)');
        $this->addSql('CREATE INDEX IDX_260AB2056C8DF983 ON flower_item (bouquet_id)');
        $this->addSql('ALTER TABLE flower_item ADD CONSTRAINT FK_260AB2052C09D409 FOREIGN KEY (flower_id) REFERENCES flower (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flower_item ADD CONSTRAINT FK_260AB2056C8DF983 FOREIGN KEY (bouquet_id) REFERENCES bouquet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE flower_item_id_seq CASCADE');
        $this->addSql('ALTER TABLE flower_item DROP CONSTRAINT FK_260AB2052C09D409');
        $this->addSql('ALTER TABLE flower_item DROP CONSTRAINT FK_260AB2056C8DF983');
        $this->addSql('DROP TABLE flower_item');
    }
}
