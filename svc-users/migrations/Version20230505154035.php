<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505154035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, school_name VARCHAR(255) NOT NULL, degree VARCHAR(255) NOT NULL, field_of_study VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_DB0A5ED2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE privacy_settings (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, setting_name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_F88CCF46A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_connection (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, social_network_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, INDEX IDX_E7A4C1A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(180) NOT NULL, last_name VARCHAR(180) NOT NULL, gender VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL, profile_picture VARCHAR(255) NOT NULL, cover_photo VARCHAR(255) NOT NULL, biography LONGTEXT NOT NULL, follower_relationships LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', following_relationships LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_experience (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, company_name VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_1EF36CD0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE privacy_settings ADD CONSTRAINT FK_F88CCF46A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE social_connection ADD CONSTRAINT FK_E7A4C1A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE work_experience ADD CONSTRAINT FK_1EF36CD0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE education DROP FOREIGN KEY FK_DB0A5ED2A76ED395');
        $this->addSql('ALTER TABLE privacy_settings DROP FOREIGN KEY FK_F88CCF46A76ED395');
        $this->addSql('ALTER TABLE social_connection DROP FOREIGN KEY FK_E7A4C1A4A76ED395');
        $this->addSql('ALTER TABLE work_experience DROP FOREIGN KEY FK_1EF36CD0A76ED395');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE privacy_settings');
        $this->addSql('DROP TABLE social_connection');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE work_experience');
    }
}
