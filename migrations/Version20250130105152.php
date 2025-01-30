<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130105152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, tournoi_id INT DEFAULT NULL, INDEX IDX_FD71A9C5A76ED395 (user_id), INDEX IDX_FD71A9C5F607770A (tournoi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matchs (id INT AUTO_INCREMENT NOT NULL, tournoi_id INT DEFAULT NULL, joueur1_id INT DEFAULT NULL, joueur2_id INT DEFAULT NULL, score_joueur1 INT NOT NULL, score_joueur2 INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_6B1E6041F607770A (tournoi_id), INDEX IDX_6B1E604192C1E237 (joueur1_id), INDEX IDX_6B1E604180744DD9 (joueur2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournoi (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_by VARCHAR(255) NOT NULL, INDEX IDX_18AFD9DFC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, typetournoi VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C5F607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E6041F607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E604192C1E237 FOREIGN KEY (joueur1_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E604180744DD9 FOREIGN KEY (joueur2_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE tournoi ADD CONSTRAINT FK_18AFD9DFC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C5A76ED395');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C5F607770A');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E6041F607770A');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E604192C1E237');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E604180744DD9');
        $this->addSql('ALTER TABLE tournoi DROP FOREIGN KEY FK_18AFD9DFC54C8C93');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE matchs');
        $this->addSql('DROP TABLE tournoi');
        $this->addSql('DROP TABLE type');
    }
}
