<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231107004342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE database_credentials ADD environment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE database_credentials ADD CONSTRAINT FK_FB4AD00D903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id)');
        $this->addSql('CREATE INDEX IDX_FB4AD00D903E3A94 ON database_credentials (environment_id)');
        $this->addSql('ALTER TABLE projects CHANGE type type ENUM(\'Normal\',\'Database\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE database_credentials DROP FOREIGN KEY FK_FB4AD00D903E3A94');
        $this->addSql('DROP INDEX IDX_FB4AD00D903E3A94 ON database_credentials');
        $this->addSql('ALTER TABLE database_credentials DROP environment_id');
        $this->addSql('ALTER TABLE projects CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
