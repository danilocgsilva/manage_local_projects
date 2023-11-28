<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231128012126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE database_name (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE database_credentials ADD database_name VARCHAR(255) NOT NULL, CHANGE name credentials_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects CHANGE type type ENUM(\'Normal\',\'Database\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE database_name');
        $this->addSql('ALTER TABLE database_credentials DROP database_name, CHANGE credentials_name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projects CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
