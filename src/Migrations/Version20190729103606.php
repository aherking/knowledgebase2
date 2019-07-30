<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190729103606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tag ADD description VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE entry_tag DROP FOREIGN KEY FK_F035C9E5BA364942');
        $this->addSql('ALTER TABLE entry_tag DROP FOREIGN KEY FK_F035C9E5BAD26311');
        $this->addSql('ALTER TABLE entry_tag ADD CONSTRAINT FK_F035C9E5BA364942 FOREIGN KEY (entry_id) REFERENCES entry (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entry_tag ADD CONSTRAINT FK_F035C9E5BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE entry_tag DROP FOREIGN KEY FK_F035C9E5BA364942');
        $this->addSql('ALTER TABLE entry_tag DROP FOREIGN KEY FK_F035C9E5BAD26311');
        $this->addSql('ALTER TABLE entry_tag ADD CONSTRAINT FK_F035C9E5BA364942 FOREIGN KEY (entry_id) REFERENCES entry (id)');
        $this->addSql('ALTER TABLE entry_tag ADD CONSTRAINT FK_F035C9E5BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE tag DROP description');
    }
}
