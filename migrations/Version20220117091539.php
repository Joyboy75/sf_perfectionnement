<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220117091539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C17294869C');
        $this->addSql('DROP INDEX IDX_64C19C17294869C ON category');
        $this->addSql('ALTER TABLE category DROP article_id');
        $this->addSql('ALTER TABLE writer DROP FOREIGN KEY FK_97A0D8827294869C');
        $this->addSql('DROP INDEX IDX_97A0D8827294869C ON writer');
        $this->addSql('ALTER TABLE writer DROP article_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C17294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_64C19C17294869C ON category (article_id)');
        $this->addSql('ALTER TABLE writer ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE writer ADD CONSTRAINT FK_97A0D8827294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_97A0D8827294869C ON writer (article_id)');
    }
}
