<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116230212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE deploy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deploy_environment (deploy_id INT NOT NULL, environment_id INT NOT NULL, INDEX IDX_50F8D3877886667B (deploy_id), INDEX IDX_50F8D387903E3A94 (environment_id), PRIMARY KEY(deploy_id, environment_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deploy_receipt (deploy_id INT NOT NULL, receipt_id INT NOT NULL, INDEX IDX_178D37917886667B (deploy_id), INDEX IDX_178D37912B5CA896 (receipt_id), PRIMARY KEY(deploy_id, receipt_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deploy_environment ADD CONSTRAINT FK_50F8D3877886667B FOREIGN KEY (deploy_id) REFERENCES deploy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deploy_environment ADD CONSTRAINT FK_50F8D387903E3A94 FOREIGN KEY (environment_id) REFERENCES environment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deploy_receipt ADD CONSTRAINT FK_178D37917886667B FOREIGN KEY (deploy_id) REFERENCES deploy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deploy_receipt ADD CONSTRAINT FK_178D37912B5CA896 FOREIGN KEY (receipt_id) REFERENCES receipt (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects CHANGE type type ENUM(\'Normal\',\'Database\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deploy_environment DROP FOREIGN KEY FK_50F8D3877886667B');
        $this->addSql('ALTER TABLE deploy_environment DROP FOREIGN KEY FK_50F8D387903E3A94');
        $this->addSql('ALTER TABLE deploy_receipt DROP FOREIGN KEY FK_178D37917886667B');
        $this->addSql('ALTER TABLE deploy_receipt DROP FOREIGN KEY FK_178D37912B5CA896');
        $this->addSql('DROP TABLE deploy');
        $this->addSql('DROP TABLE deploy_environment');
        $this->addSql('DROP TABLE deploy_receipt');
        $this->addSql('ALTER TABLE projects CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
