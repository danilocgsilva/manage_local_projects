<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231119185438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deploy ADD project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deploy ADD CONSTRAINT FK_923B38FA166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('CREATE INDEX IDX_923B38FA166D1F9C ON deploy (project_id)');
        $this->addSql('ALTER TABLE projects CHANGE type type ENUM(\'Normal\',\'Database\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deploy DROP FOREIGN KEY FK_923B38FA166D1F9C');
        $this->addSql('DROP INDEX IDX_923B38FA166D1F9C ON deploy');
        $this->addSql('ALTER TABLE deploy DROP project_id');
        $this->addSql('ALTER TABLE projects CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
