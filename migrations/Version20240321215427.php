<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321215427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE cart DROP FOREIGN KEY UNIQ_BA388B78D9F6D38');
        // $this->addSql('DROP INDEX UNIQ_BA388B78D9F6D38 ON cart');
        // $this->addSql('ALTER TABLE cart DROP order_id');

        // supprimer la colonne order_id d'index UNIQ_BA388B78D9F6D38
 // Supprimer la clé étrangère UNIQ_BA388B78D9F6D38
    $this->addSql('ALTER TABLE cart DROP FOREIGN KEY UNIQ_BA388B78D9F6D38');
    
    // Supprimer l'index UNIQ_BA388B78D9F6D38
    $this->addSql('DROP INDEX UNIQ_BA388B78D9F6D38 ON cart');
    
    // Supprimer la colonne order_id
    $this->addSql('ALTER TABLE cart DROP COLUMN order_id');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE cart DROP FOREIGN KEY UNIQ_BA388B78D9F6D38');
        // $this->addSql('DROP INDEX UNIQ_BA388B78D9F6D38 ON cart');
        // $this->addSql('ALTER TABLE cart DROP order_id');
    }
}
