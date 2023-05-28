<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509210716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cart_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cart (id INT NOT NULL, total_price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cart_cart_item (cart_id INT NOT NULL, cart_item_id INT NOT NULL, PRIMARY KEY(cart_id, cart_item_id))');
        $this->addSql('CREATE INDEX IDX_2A0002B81AD5CDBF ON cart_cart_item (cart_id)');
        $this->addSql('CREATE INDEX IDX_2A0002B8E9B59A59 ON cart_cart_item (cart_item_id)');
        $this->addSql('CREATE TABLE cart_item (id INT NOT NULL, bouquet_id INT DEFAULT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0FE25276C8DF983 ON cart_item (bouquet_id)');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, cart_id INT DEFAULT NULL, order_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, total_price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F52993981AD5CDBF ON "order" (cart_id)');
        $this->addSql('ALTER TABLE cart_cart_item ADD CONSTRAINT FK_2A0002B81AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_cart_item ADD CONSTRAINT FK_2A0002B8E9B59A59 FOREIGN KEY (cart_item_id) REFERENCES cart_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25276C8DF983 FOREIGN KEY (bouquet_id) REFERENCES bouquet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993981AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bouquet ADD package_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bouquet ADD decoration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bouquet ADD CONSTRAINT FK_878E1707F44CABFF FOREIGN KEY (package_id) REFERENCES package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bouquet ADD CONSTRAINT FK_878E17073446DFC4 FOREIGN KEY (decoration_id) REFERENCES decoration (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_878E1707F44CABFF ON bouquet (package_id)');
        $this->addSql('CREATE INDEX IDX_878E17073446DFC4 ON bouquet (decoration_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cart_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('ALTER TABLE cart_cart_item DROP CONSTRAINT FK_2A0002B81AD5CDBF');
        $this->addSql('ALTER TABLE cart_cart_item DROP CONSTRAINT FK_2A0002B8E9B59A59');
        $this->addSql('ALTER TABLE cart_item DROP CONSTRAINT FK_F0FE25276C8DF983');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993981AD5CDBF');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_cart_item');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('ALTER TABLE bouquet DROP CONSTRAINT FK_878E1707F44CABFF');
        $this->addSql('ALTER TABLE bouquet DROP CONSTRAINT FK_878E17073446DFC4');
        $this->addSql('DROP INDEX IDX_878E1707F44CABFF');
        $this->addSql('DROP INDEX IDX_878E17073446DFC4');
        $this->addSql('ALTER TABLE bouquet DROP package_id');
        $this->addSql('ALTER TABLE bouquet DROP decoration_id');
    }
}
