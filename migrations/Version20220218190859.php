<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220218190859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket ADD user_id INT NOT NULL, ADD shirt_id INT NOT NULL');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B2E108D4C FOREIGN KEY (shirt_id) REFERENCES shirt (id)');
        $this->addSql('CREATE INDEX IDX_2246507BA76ED395 ON basket (user_id)');
        $this->addSql('CREATE INDEX IDX_2246507B2E108D4C ON basket (shirt_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507BA76ED395');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B2E108D4C');
        $this->addSql('DROP INDEX IDX_2246507BA76ED395 ON basket');
        $this->addSql('DROP INDEX IDX_2246507B2E108D4C ON basket');
        $this->addSql('ALTER TABLE basket DROP user_id, DROP shirt_id');
    }
}
