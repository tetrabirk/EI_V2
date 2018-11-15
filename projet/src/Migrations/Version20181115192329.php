<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181115192329 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE completed_task DROP FOREIGN KEY FK_36FC2E196B20BA36');
        $this->addSql('ALTER TABLE completed_task DROP FOREIGN KEY FK_36FC2E198DB60186');
        $this->addSql('ALTER TABLE completed_task CHANGE worker_id worker_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE completed_task ADD CONSTRAINT FK_36FC2E196B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE completed_task ADD CONSTRAINT FK_36FC2E198DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_day DROP FOREIGN KEY FK_9FCE7E0CF675F31B');
        $this->addSql('ALTER TABLE work_day DROP FOREIGN KEY FK_9FCE7E0CF6BD1646');
        $this->addSql('ALTER TABLE work_day CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE work_day ADD CONSTRAINT FK_9FCE7E0CF675F31B FOREIGN KEY (author_id) REFERENCES worker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_day ADD CONSTRAINT FK_9FCE7E0CF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE completed_task DROP FOREIGN KEY FK_36FC2E198DB60186');
        $this->addSql('ALTER TABLE completed_task DROP FOREIGN KEY FK_36FC2E196B20BA36');
        $this->addSql('ALTER TABLE completed_task CHANGE worker_id worker_id INT NOT NULL');
        $this->addSql('ALTER TABLE completed_task ADD CONSTRAINT FK_36FC2E198DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE completed_task ADD CONSTRAINT FK_36FC2E196B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE work_day DROP FOREIGN KEY FK_9FCE7E0CF675F31B');
        $this->addSql('ALTER TABLE work_day DROP FOREIGN KEY FK_9FCE7E0CF6BD1646');
        $this->addSql('ALTER TABLE work_day CHANGE site_id site_id INT NOT NULL');
        $this->addSql('ALTER TABLE work_day ADD CONSTRAINT FK_9FCE7E0CF675F31B FOREIGN KEY (author_id) REFERENCES worker (id)');
        $this->addSql('ALTER TABLE work_day ADD CONSTRAINT FK_9FCE7E0CF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
    }
}
