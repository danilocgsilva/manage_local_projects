<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022124713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE receipt_project (receipt_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_3CF975102B5CA896 (receipt_id), INDEX IDX_3CF97510166D1F9C (project_id), PRIMARY KEY(receipt_id, project_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE receipt_project ADD CONSTRAINT FK_3CF975102B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE receipt_project ADD CONSTRAINT FK_3CF97510166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects CHANGE type type ENUM(\'Normal\',\'Database\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE receipt_project DROP FOREIGN KEY FK_3CF975102B5CA896');
        $this->addSql('ALTER TABLE receipt_project DROP FOREIGN KEY FK_3CF97510166D1F9C');
        $this->addSql('DROP TABLE receipt_project');
        $this->addSql('ALTER TABLE projects CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
