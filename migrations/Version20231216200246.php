<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231216200246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE git_address DROP INDEX UNIQ_8EF1DEA1166D1F9C, ADD INDEX IDX_8EF1DEA1166D1F9C (project_id)');
        $this->addSql('ALTER TABLE projects CHANGE type type ENUM(\'Normal\',\'Database\')');
        $this->addSql('ALTER TABLE receipt DROP docker_volume_path');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receipt ADD docker_volume_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE git_address DROP INDEX IDX_8EF1DEA1166D1F9C, ADD UNIQUE INDEX UNIQ_8EF1DEA1166D1F9C (project_id)');
        $this->addSql('ALTER TABLE projects CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
