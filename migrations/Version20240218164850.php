<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218164850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7F8E52D6A');
        $this->addSql('DROP INDEX UNIQ_BA388B7F8E52D6A ON cart');
        $this->addSql('ALTER TABLE cart CHANGE id__id order_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B78D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B78D9F6D38 ON cart (order_id)');
        $this->addSql('ALTER TABLE customer_address DROP FOREIGN KEY FK_1193CB3FF8E52D6A');
        $this->addSql('DROP INDEX IDX_1193CB3FF8E52D6A ON customer_address');
        $this->addSql('ALTER TABLE customer_address CHANGE id__id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer_address ADD CONSTRAINT FK_1193CB3FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1193CB3FA76ED395 ON customer_address (user_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F8E52D6A');
        $this->addSql('DROP INDEX IDX_F5299398F8E52D6A ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE id__id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B78D9F6D38');
        $this->addSql('DROP INDEX UNIQ_BA388B78D9F6D38 ON cart');
        $this->addSql('ALTER TABLE cart CHANGE order_id id__id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7F8E52D6A FOREIGN KEY (id__id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7F8E52D6A ON cart (id__id)');
        $this->addSql('ALTER TABLE customer_address DROP FOREIGN KEY FK_1193CB3FA76ED395');
        $this->addSql('DROP INDEX IDX_1193CB3FA76ED395 ON customer_address');
        $this->addSql('ALTER TABLE customer_address CHANGE user_id id__id INT NOT NULL');
        $this->addSql('ALTER TABLE customer_address ADD CONSTRAINT FK_1193CB3FF8E52D6A FOREIGN KEY (id__id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1193CB3FF8E52D6A ON customer_address (id__id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE user_id id__id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F8E52D6A FOREIGN KEY (id__id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F5299398F8E52D6A ON `order` (id__id)');
    }
}
