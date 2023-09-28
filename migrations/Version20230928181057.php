<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928181057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carts_carts (id_value VARCHAR(255) NOT NULL, owner_id VARCHAR(255) DEFAULT NULL, coupon_id VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C2A197877E3C61F9 (owner_id), INDEX IDX_C2A1978766C5951B (coupon_id), PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carts_carts_items (id_value VARCHAR(255) NOT NULL, cart_id VARCHAR(255) DEFAULT NULL, product_id VARCHAR(255) DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_6C49E6FF1AD5CDBF (cart_id), INDEX IDX_6C49E6FF4584665A (product_id), PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carts_carts_items_features_values (cart_item_id VARCHAR(255) NOT NULL, feature_value_id VARCHAR(255) NOT NULL, INDEX IDX_791593F0E9B59A59 (cart_item_id), INDEX IDX_791593F080CD149D (feature_value_id), PRIMARY KEY(cart_item_id, feature_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carts_carts_owners (id_value VARCHAR(255) NOT NULL, guests_key VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupons (id_value VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(50) NOT NULL, sale_type VARCHAR(50) NOT NULL, sale_value INT NOT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE features (id_value VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE features_values (id_value VARCHAR(255) NOT NULL, feature_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5C5A477560E4B879 (feature_id), PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id_value VARCHAR(255) NOT NULL, info_path VARCHAR(255) NOT NULL, info_name VARCHAR(255) NOT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id_value VARCHAR(255) NOT NULL, total NUMERIC(10, 2) DEFAULT NULL, note VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_brands (id_value VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_categories (id_value VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_products (id_value VARCHAR(255) NOT NULL, category_id VARCHAR(255) DEFAULT NULL, brand_id VARCHAR(255) DEFAULT NULL, tag_id VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, rating NUMERIC(8, 2) NOT NULL, price_new NUMERIC(8, 2) NOT NULL, price_old NUMERIC(8, 2) NOT NULL, status_value VARCHAR(50) NOT NULL, info_name VARCHAR(255) NOT NULL, info_description VARCHAR(1000) NOT NULL, info_specification VARCHAR(1000) NOT NULL, INDEX IDX_A6BB4AE912469DE2 (category_id), INDEX IDX_A6BB4AE944F5D008 (brand_id), INDEX IDX_A6BB4AE9BAD26311 (tag_id), PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_products_images (product_id VARCHAR(255) NOT NULL, image_id VARCHAR(255) NOT NULL, INDEX IDX_2EC0ECFB4584665A (product_id), INDEX IDX_2EC0ECFB3DA5256D (image_id), PRIMARY KEY(product_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_products_features_values (product_id VARCHAR(255) NOT NULL, feature_value_id VARCHAR(255) NOT NULL, INDEX IDX_E0DEE9DB4584665A (product_id), INDEX IDX_E0DEE9DB80CD149D (feature_value_id), PRIMARY KEY(product_id, feature_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_tags (id_value VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id_value VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id_value)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carts_carts ADD CONSTRAINT FK_C2A197877E3C61F9 FOREIGN KEY (owner_id) REFERENCES carts_carts_owners (id_value)');
        $this->addSql('ALTER TABLE carts_carts ADD CONSTRAINT FK_C2A1978766C5951B FOREIGN KEY (coupon_id) REFERENCES coupons (id_value)');
        $this->addSql('ALTER TABLE carts_carts_items ADD CONSTRAINT FK_6C49E6FF1AD5CDBF FOREIGN KEY (cart_id) REFERENCES carts_carts (id_value)');
        $this->addSql('ALTER TABLE carts_carts_items ADD CONSTRAINT FK_6C49E6FF4584665A FOREIGN KEY (product_id) REFERENCES products_products (id_value)');
        $this->addSql('ALTER TABLE carts_carts_items_features_values ADD CONSTRAINT FK_791593F0E9B59A59 FOREIGN KEY (cart_item_id) REFERENCES carts_carts_items (id_value)');
        $this->addSql('ALTER TABLE carts_carts_items_features_values ADD CONSTRAINT FK_791593F080CD149D FOREIGN KEY (feature_value_id) REFERENCES features_values (id_value)');
        $this->addSql('ALTER TABLE features_values ADD CONSTRAINT FK_5C5A477560E4B879 FOREIGN KEY (feature_id) REFERENCES features (id_value)');
        $this->addSql('ALTER TABLE products_products ADD CONSTRAINT FK_A6BB4AE912469DE2 FOREIGN KEY (category_id) REFERENCES products_categories (id_value)');
        $this->addSql('ALTER TABLE products_products ADD CONSTRAINT FK_A6BB4AE944F5D008 FOREIGN KEY (brand_id) REFERENCES products_brands (id_value)');
        $this->addSql('ALTER TABLE products_products ADD CONSTRAINT FK_A6BB4AE9BAD26311 FOREIGN KEY (tag_id) REFERENCES products_tags (id_value)');
        $this->addSql('ALTER TABLE products_products_images ADD CONSTRAINT FK_2EC0ECFB4584665A FOREIGN KEY (product_id) REFERENCES products_products (id_value)');
        $this->addSql('ALTER TABLE products_products_images ADD CONSTRAINT FK_2EC0ECFB3DA5256D FOREIGN KEY (image_id) REFERENCES images (id_value)');
        $this->addSql('ALTER TABLE products_products_features_values ADD CONSTRAINT FK_E0DEE9DB4584665A FOREIGN KEY (product_id) REFERENCES products_products (id_value)');
        $this->addSql('ALTER TABLE products_products_features_values ADD CONSTRAINT FK_E0DEE9DB80CD149D FOREIGN KEY (feature_value_id) REFERENCES features_values (id_value)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carts_carts DROP FOREIGN KEY FK_C2A197877E3C61F9');
        $this->addSql('ALTER TABLE carts_carts DROP FOREIGN KEY FK_C2A1978766C5951B');
        $this->addSql('ALTER TABLE carts_carts_items DROP FOREIGN KEY FK_6C49E6FF1AD5CDBF');
        $this->addSql('ALTER TABLE carts_carts_items DROP FOREIGN KEY FK_6C49E6FF4584665A');
        $this->addSql('ALTER TABLE carts_carts_items_features_values DROP FOREIGN KEY FK_791593F0E9B59A59');
        $this->addSql('ALTER TABLE carts_carts_items_features_values DROP FOREIGN KEY FK_791593F080CD149D');
        $this->addSql('ALTER TABLE features_values DROP FOREIGN KEY FK_5C5A477560E4B879');
        $this->addSql('ALTER TABLE products_products DROP FOREIGN KEY FK_A6BB4AE912469DE2');
        $this->addSql('ALTER TABLE products_products DROP FOREIGN KEY FK_A6BB4AE944F5D008');
        $this->addSql('ALTER TABLE products_products DROP FOREIGN KEY FK_A6BB4AE9BAD26311');
        $this->addSql('ALTER TABLE products_products_images DROP FOREIGN KEY FK_2EC0ECFB4584665A');
        $this->addSql('ALTER TABLE products_products_images DROP FOREIGN KEY FK_2EC0ECFB3DA5256D');
        $this->addSql('ALTER TABLE products_products_features_values DROP FOREIGN KEY FK_E0DEE9DB4584665A');
        $this->addSql('ALTER TABLE products_products_features_values DROP FOREIGN KEY FK_E0DEE9DB80CD149D');
        $this->addSql('DROP TABLE carts_carts');
        $this->addSql('DROP TABLE carts_carts_items');
        $this->addSql('DROP TABLE carts_carts_items_features_values');
        $this->addSql('DROP TABLE carts_carts_owners');
        $this->addSql('DROP TABLE coupons');
        $this->addSql('DROP TABLE features');
        $this->addSql('DROP TABLE features_values');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE products_brands');
        $this->addSql('DROP TABLE products_categories');
        $this->addSql('DROP TABLE products_products');
        $this->addSql('DROP TABLE products_products_images');
        $this->addSql('DROP TABLE products_products_features_values');
        $this->addSql('DROP TABLE products_tags');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
