<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926185419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carts_carts (id INT AUTO_INCREMENT NOT NULL, owner_id VARCHAR(255) DEFAULT NULL, coupon_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C2A197877E3C61F9 (owner_id), INDEX IDX_C2A1978766C5951B (coupon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carts_carts_items (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, product_id INT DEFAULT NULL, quantity INT NOT NULL, features_value VARCHAR(255) DEFAULT NULL, INDEX IDX_6C49E6FF1AD5CDBF (cart_id), INDEX IDX_6C49E6FF4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carts_carts_owners (id_value VARCHAR(255) NOT NULL, guests_key VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carts_carts ADD CONSTRAINT FK_C2A197877E3C61F9 FOREIGN KEY (owner_id) REFERENCES carts_carts_owners (id_value)');
        $this->addSql('ALTER TABLE carts_carts ADD CONSTRAINT FK_C2A1978766C5951B FOREIGN KEY (coupon_id) REFERENCES coupons (id)');
        $this->addSql('ALTER TABLE carts_carts_items ADD CONSTRAINT FK_6C49E6FF1AD5CDBF FOREIGN KEY (cart_id) REFERENCES carts_carts (id)');
        $this->addSql('ALTER TABLE carts_carts_items ADD CONSTRAINT FK_6C49E6FF4584665A FOREIGN KEY (product_id) REFERENCES products_products (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carts_carts DROP FOREIGN KEY FK_C2A197877E3C61F9');
        $this->addSql('ALTER TABLE carts_carts DROP FOREIGN KEY FK_C2A1978766C5951B');
        $this->addSql('ALTER TABLE carts_carts_items DROP FOREIGN KEY FK_6C49E6FF1AD5CDBF');
        $this->addSql('ALTER TABLE carts_carts_items DROP FOREIGN KEY FK_6C49E6FF4584665A');
        $this->addSql('DROP TABLE carts_carts');
        $this->addSql('DROP TABLE carts_carts_items');
        $this->addSql('DROP TABLE carts_carts_owners');
    }
}
