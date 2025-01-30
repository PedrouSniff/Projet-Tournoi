<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130095824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classement (id INT AUTO_INCREMENT NOT NULL, classe_nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD classement_id INT NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prénom VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A513A63E FOREIGN KEY (classement_id) REFERENCES classement (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A513A63E ON user (classement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A513A63E');
        $this->addSql('DROP TABLE classement');
        $this->addSql('DROP INDEX IDX_8D93D649A513A63E ON user');
        $this->addSql('ALTER TABLE user DROP classement_id, DROP nom, DROP prénom, DROP created_at, DROP image_name, DROP updated_at');
    }
}
