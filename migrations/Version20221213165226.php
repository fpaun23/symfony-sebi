<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213165226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jobs DROP FOREIGN KEY FK_A8936DC538B53C32');
        $this->addSql('ALTER TABLE jobs ADD active INT NOT NULL, ADD priority INT NOT NULL');
        $this->addSql('DROP INDEX idx_a8936dc538b53c32 ON jobs');
        $this->addSql('CREATE INDEX IDX_A8936DC5979B1AD6 ON jobs (company_id)');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC538B53C32 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jobs DROP FOREIGN KEY FK_A8936DC5979B1AD6');
        $this->addSql('ALTER TABLE jobs DROP active, DROP priority');
        $this->addSql('DROP INDEX idx_a8936dc5979b1ad6 ON jobs');
        $this->addSql('CREATE INDEX IDX_A8936DC538B53C32 ON jobs (company_id)');
        $this->addSql('ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC5979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }
}
