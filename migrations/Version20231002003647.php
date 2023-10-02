<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002003647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE environment ADD project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE environment ADD CONSTRAINT FK_4626DE22166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('CREATE INDEX IDX_4626DE22166D1F9C ON environment (project_id)');
        $this->addSql('ALTER TABLE projects CHANGE type type ENUM(\'Normal\',\'Database\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE environment DROP FOREIGN KEY FK_4626DE22166D1F9C');
        $this->addSql('DROP INDEX IDX_4626DE22166D1F9C ON environment');
        $this->addSql('ALTER TABLE environment DROP project_id');
        $this->addSql('ALTER TABLE projects CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
