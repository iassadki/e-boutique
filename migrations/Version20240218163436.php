<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218163436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD id__id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7F8E52D6A FOREIGN KEY (id__id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7F8E52D6A ON cart (id__id)');
        $this->addSql('CREATE INDEX IDX_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('ALTER TABLE cart_line ADD product_id INT NOT NULL, ADD cart_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_3EF1B4CF4584665A ON cart_line (product_id)');
        $this->addSql('CREATE INDEX IDX_3EF1B4CF1AD5CDBF ON cart_line (cart_id)');
        $this->addSql('ALTER TABLE command_line ADD order_id INT NOT NULL, ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE command_line ADD CONSTRAINT FK_70BE1A7B8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE command_line ADD CONSTRAINT FK_70BE1A7B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_70BE1A7B8D9F6D38 ON command_line (order_id)');
        $this->addSql('CREATE INDEX IDX_70BE1A7B4584665A ON command_line (product_id)');
        $this->addSql('ALTER TABLE customer_address ADD id__id INT NOT NULL');
        $this->addSql('ALTER TABLE customer_address ADD CONSTRAINT FK_1193CB3FF8E52D6A FOREIGN KEY (id__id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1193CB3FF8E52D6A ON customer_address (id__id)');
        $this->addSql('ALTER TABLE media ADD product_id INT NOT NULL, ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C4584665A ON media (product_id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C12469DE2 ON media (category_id)');
        $this->addSql('ALTER TABLE `order` ADD id__id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F8E52D6A FOREIGN KEY (id__id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398F8E52D6A ON `order` (id__id)');
        $this->addSql('ALTER TABLE product ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7F8E52D6A');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('DROP INDEX UNIQ_BA388B7F8E52D6A ON cart');
        $this->addSql('DROP INDEX IDX_BA388B7A76ED395 ON cart');
        $this->addSql('ALTER TABLE cart DROP id__id, DROP user_id');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF4584665A');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF1AD5CDBF');
        $this->addSql('DROP INDEX IDX_3EF1B4CF4584665A ON cart_line');
        $this->addSql('DROP INDEX IDX_3EF1B4CF1AD5CDBF ON cart_line');
        $this->addSql('ALTER TABLE cart_line DROP product_id, DROP cart_id');
        $this->addSql('ALTER TABLE command_line DROP FOREIGN KEY FK_70BE1A7B8D9F6D38');
        $this->addSql('ALTER TABLE command_line DROP FOREIGN KEY FK_70BE1A7B4584665A');
        $this->addSql('DROP INDEX IDX_70BE1A7B8D9F6D38 ON command_line');
        $this->addSql('DROP INDEX IDX_70BE1A7B4584665A ON command_line');
        $this->addSql('ALTER TABLE command_line DROP order_id, DROP product_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product DROP category_id');
        $this->addSql('ALTER TABLE customer_address DROP FOREIGN KEY FK_1193CB3FF8E52D6A');
        $this->addSql('DROP INDEX IDX_1193CB3FF8E52D6A ON customer_address');
        $this->addSql('ALTER TABLE customer_address DROP id__id');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4584665A');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C12469DE2');
        $this->addSql('DROP INDEX IDX_6A2CA10C4584665A ON media');
        $this->addSql('DROP INDEX IDX_6A2CA10C12469DE2 ON media');
        $this->addSql('ALTER TABLE media DROP product_id, DROP category_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F8E52D6A');
        $this->addSql('DROP INDEX IDX_F5299398F8E52D6A ON `order`');
        $this->addSql('ALTER TABLE `order` DROP id__id');
    }
}
