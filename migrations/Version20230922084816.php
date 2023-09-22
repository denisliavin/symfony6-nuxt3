<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922084816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_products_images DROP FOREIGN KEY FK_2EC0ECFB3DA5256D');
        $this->addSql('ALTER TABLE products_products_images DROP FOREIGN KEY FK_2EC0ECFB4584665A');
        $this->addSql('ALTER TABLE products_products_images ADD CONSTRAINT FK_2EC0ECFB3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_products_images ADD CONSTRAINT FK_2EC0ECFB4584665A FOREIGN KEY (product_id) REFERENCES products_products (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products_products_images DROP FOREIGN KEY FK_2EC0ECFB4584665A');
        $this->addSql('ALTER TABLE products_products_images DROP FOREIGN KEY FK_2EC0ECFB3DA5256D');
        $this->addSql('ALTER TABLE products_products_images ADD CONSTRAINT FK_2EC0ECFB4584665A FOREIGN KEY (product_id) REFERENCES products_products (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE products_products_images ADD CONSTRAINT FK_2EC0ECFB3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
