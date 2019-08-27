<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190827083531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, id_sender_id INT NOT NULL, id_recipient_id INT NOT NULL, creation_date DATETIME NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_B6BD307F76110FBA (id_sender_id), INDEX IDX_B6BD307FCAEEFA0A (id_recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F76110FBA FOREIGN KEY (id_sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCAEEFA0A FOREIGN KEY (id_recipient_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE tchat');
        $this->addSql('ALTER TABLE game CHANGE theme theme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE zip_code zip_code VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE user_game_association CHANGE rating rating INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tchat (id INT NOT NULL, id_username INT NOT NULL, message TEXT NOT NULL COLLATE utf8mb4_unicode_ci, date_message DATETIME NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE game CHANGE theme theme VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE avatar avatar VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE zip_code zip_code INT NOT NULL');
        $this->addSql('ALTER TABLE user_game_association CHANGE rating rating INT DEFAULT NULL');
    }
}
