<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190820152011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game CHANGE theme theme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP roles, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE zip_code zip_code VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE user_game_association CHANGE rating rating INT DEFAULT NULL');

        $this->addSql('ALTER TABLE user CHANGE zip_code zip_code VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game CHANGE theme theme VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user ADD roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE avatar avatar VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE zip_code zip_code INT NOT NULL');
        $this->addSql('ALTER TABLE user_game_association CHANGE rating rating INT DEFAULT NULL');
        
        $this->addSql('ALTER TABLE user CHANGE zip_code zip_code INT NOT NULL');
    }
}
