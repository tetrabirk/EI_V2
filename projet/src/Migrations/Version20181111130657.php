<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181111130657 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE work_day ADD author_id INT NOT NULL, ADD site_id INT NOT NULL');
        $this->addSql('ALTER TABLE work_day ADD CONSTRAINT FK_9FCE7E0CF675F31B FOREIGN KEY (author_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE work_day ADD CONSTRAINT FK_9FCE7E0CF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_9FCE7E0CF675F31B ON work_day (author_id)');
        $this->addSql('CREATE INDEX IDX_9FCE7E0CF6BD1646 ON work_day (site_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE work_day DROP FOREIGN KEY FK_9FCE7E0CF675F31B');
        $this->addSql('ALTER TABLE work_day DROP FOREIGN KEY FK_9FCE7E0CF6BD1646');
        $this->addSql('DROP INDEX IDX_9FCE7E0CF675F31B ON work_day');
        $this->addSql('DROP INDEX IDX_9FCE7E0CF6BD1646 ON work_day');
        $this->addSql('ALTER TABLE work_day DROP author_id, DROP site_id');
    }
}
