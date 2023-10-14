<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231014142032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE environment_file (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE environment_file_environment (environment_file_id INT NOT NULL, environment_id INT NOT NULL, INDEX IDX_90A172D9A16ACEE0 (environment_file_id), INDEX IDX_90A172D9903E3A94 (environment_id), PRIMARY KEY(environment_file_id, environment_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE environment_file_environment ADD CONSTRAINT FK_90A172D9A16ACEE0 FOREIGN KEY (environment_file_id) REFERENCES environment_file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE environment_file_environment ADD CONSTRAINT FK_90A172D9903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects CHANGE type type ENUM(\'Normal\',\'Database\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE environment_file_environment DROP FOREIGN KEY FK_90A172D9A16ACEE0');
        $this->addSql('ALTER TABLE environment_file_environment DROP FOREIGN KEY FK_90A172D9903E3A94');
        $this->addSql('DROP TABLE environment_file');
        $this->addSql('DROP TABLE environment_file_environment');
        $this->addSql('ALTER TABLE projects CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
