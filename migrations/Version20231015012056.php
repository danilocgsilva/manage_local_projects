<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231015012056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `database` (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, user VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, table_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE database_credentials (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) DEFAULT NULL, host VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, port INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE environment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, uname_n_fingerprint VARCHAR(255) DEFAULT NULL, uname_a_fingerprint VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE environment_file (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE environment_file_environment (environment_file_id INT NOT NULL, environment_id INT NOT NULL, INDEX IDX_90A172D9A16ACEE0 (environment_file_id), INDEX IDX_90A172D9903E3A94 (environment_id), PRIMARY KEY(environment_file_id, environment_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE git_address (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8EF1DEA1166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type ENUM(\'Normal\',\'Database\'), deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_environment (project_id INT NOT NULL, environment_id INT NOT NULL, INDEX IDX_8EE929D9166D1F9C (project_id), INDEX IDX_8EE929D9903E3A94 (environment_id), PRIMARY KEY(project_id, environment_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receipt (id INT AUTO_INCREMENT NOT NULL, receipt LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE environment_file_environment ADD CONSTRAINT FK_90A172D9A16ACEE0 FOREIGN KEY (environment_file_id) REFERENCES environment_file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE environment_file_environment ADD CONSTRAINT FK_90A172D9903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE git_address ADD CONSTRAINT FK_8EF1DEA1166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE project_environment ADD CONSTRAINT FK_8EE929D9166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_environment ADD CONSTRAINT FK_8EE929D9903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE environment_file_environment DROP FOREIGN KEY FK_90A172D9A16ACEE0');
        $this->addSql('ALTER TABLE environment_file_environment DROP FOREIGN KEY FK_90A172D9903E3A94');
        $this->addSql('ALTER TABLE git_address DROP FOREIGN KEY FK_8EF1DEA1166D1F9C');
        $this->addSql('ALTER TABLE project_environment DROP FOREIGN KEY FK_8EE929D9166D1F9C');
        $this->addSql('ALTER TABLE project_environment DROP FOREIGN KEY FK_8EE929D9903E3A94');
        $this->addSql('DROP TABLE `database`');
        $this->addSql('DROP TABLE database_credentials');
        $this->addSql('DROP TABLE environment');
        $this->addSql('DROP TABLE environment_file');
        $this->addSql('DROP TABLE environment_file_environment');
        $this->addSql('DROP TABLE git_address');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE project_environment');
        $this->addSql('DROP TABLE receipt');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
