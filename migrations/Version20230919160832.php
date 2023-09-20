<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919160832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products_brands (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_categories (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_products (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, tag_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, rating NUMERIC(8, 2) NOT NULL, price_new NUMERIC(8, 2) NOT NULL, price_old NUMERIC(8, 2) NOT NULL, info_name VARCHAR(255) NOT NULL, info_description VARCHAR(1000) NOT NULL, info_specification VARCHAR(1000) NOT NULL, INDEX IDX_A6BB4AE912469DE2 (category_id), INDEX IDX_A6BB4AE944F5D008 (brand_id), INDEX IDX_A6BB4AE9BAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_products_images (product_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_2EC0ECFB4584665A (product_id), INDEX IDX_2EC0ECFB3DA5256D (image_id), PRIMARY KEY(product_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_products_features_values (product_id INT NOT NULL, feature_value_id INT NOT NULL, INDEX IDX_E0DEE9DB4584665A (product_id), INDEX IDX_E0DEE9DB80CD149D (feature_value_id), PRIMARY KEY(product_id, feature_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_tags (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products_products ADD CONSTRAINT FK_A6BB4AE912469DE2 FOREIGN KEY (category_id) REFERENCES products_categories (id)');
        $this->addSql('ALTER TABLE products_products ADD CONSTRAINT FK_A6BB4AE944F5D008 FOREIGN KEY (brand_id) REFERENCES products_brands (id)');
        $this->addSql('ALTER TABLE products_products ADD CONSTRAINT FK_A6BB4AE9BAD26311 FOREIGN KEY (tag_id) REFERENCES products_tags (id)');
        $this->addSql('ALTER TABLE products_products_images ADD CONSTRAINT FK_2EC0ECFB4584665A FOREIGN KEY (product_id) REFERENCES products_products (id)');
        $this->addSql('ALTER TABLE products_products_images ADD CONSTRAINT FK_2EC0ECFB3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE products_products_features_values ADD CONSTRAINT FK_E0DEE9DB4584665A FOREIGN KEY (product_id) REFERENCES products_products (id)');
        $this->addSql('ALTER TABLE products_products_features_values ADD CONSTRAINT FK_E0DEE9DB80CD149D FOREIGN KEY (feature_value_id) REFERENCES features_values (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_products DROP FOREIGN KEY FK_A6BB4AE912469DE2');
        $this->addSql('ALTER TABLE products_products DROP FOREIGN KEY FK_A6BB4AE944F5D008');
        $this->addSql('ALTER TABLE products_products DROP FOREIGN KEY FK_A6BB4AE9BAD26311');
        $this->addSql('ALTER TABLE products_products_images DROP FOREIGN KEY FK_2EC0ECFB4584665A');
        $this->addSql('ALTER TABLE products_products_images DROP FOREIGN KEY FK_2EC0ECFB3DA5256D');
        $this->addSql('ALTER TABLE products_products_features_values DROP FOREIGN KEY FK_E0DEE9DB4584665A');
        $this->addSql('ALTER TABLE products_products_features_values DROP FOREIGN KEY FK_E0DEE9DB80CD149D');
        $this->addSql('DROP TABLE products_brands');
        $this->addSql('DROP TABLE products_categories');
        $this->addSql('DROP TABLE products_products');
        $this->addSql('DROP TABLE products_products_images');
        $this->addSql('DROP TABLE products_products_features_values');
        $this->addSql('DROP TABLE products_tags');
    }
}
