<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181120182756 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, phone1 VARCHAR(255) DEFAULT NULL, phone2 VARCHAR(255) DEFAULT NULL, contact_email VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE completed_task (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, worker_id INT DEFAULT NULL, duration TIME NOT NULL, INDEX IDX_36FC2E198DB60186 (task_id), INDEX IDX_36FC2E196B20BA36 (worker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flag (id INT AUTO_INCREMENT NOT NULL, work_day_id INT NOT NULL, comment VARCHAR(255) NOT NULL, date DATETIME NOT NULL, viewed TINYINT(1) NOT NULL, INDEX IDX_D1F4EB9AA23B8704 (work_day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, site_id INT DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, INDEX IDX_AB55E24F217BBB47 (person_id), INDEX IDX_AB55E24FF6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, short_name VARCHAR(5) NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, post_code VARCHAR(10) DEFAULT NULL, locality VARCHAR(255) DEFAULT NULL, country VARCHAR(20) DEFAULT NULL, latitude NUMERIC(10, 7) DEFAULT NULL, longitude NUMERIC(10, 7) DEFAULT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_527EDB25F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_day (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, site_id INT DEFAULT NULL, date DATETIME NOT NULL, comment LONGTEXT DEFAULT NULL, validated TINYINT(1) NOT NULL, flagged TINYINT(1) NOT NULL, INDEX IDX_9FCE7E0CF675F31B (author_id), INDEX IDX_9FCE7E0CF6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worker (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workDays (worker_id INT NOT NULL, work_day_id INT NOT NULL, INDEX IDX_7CD31D3E6B20BA36 (worker_id), INDEX IDX_7CD31D3EA23B8704 (work_day_id), PRIMARY KEY(worker_id, work_day_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE completed_task ADD CONSTRAINT FK_36FC2E198DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE completed_task ADD CONSTRAINT FK_36FC2E196B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE flag ADD CONSTRAINT FK_D1F4EB9AA23B8704 FOREIGN KEY (work_day_id) REFERENCES work_day (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE work_day ADD CONSTRAINT FK_9FCE7E0CF675F31B FOREIGN KEY (author_id) REFERENCES worker (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE work_day ADD CONSTRAINT FK_9FCE7E0CF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF62BF396750 FOREIGN KEY (id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workDays ADD CONSTRAINT FK_7CD31D3E6B20BA36 FOREIGN KEY (worker_id) REFERENCES worker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workDays ADD CONSTRAINT FK_7CD31D3EA23B8704 FOREIGN KEY (work_day_id) REFERENCES work_day (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BF396750');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F217BBB47');
        $this->addSql('ALTER TABLE worker DROP FOREIGN KEY FK_9FB2BF62BF396750');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FF6BD1646');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25F6BD1646');
        $this->addSql('ALTER TABLE work_day DROP FOREIGN KEY FK_9FCE7E0CF6BD1646');
        $this->addSql('ALTER TABLE completed_task DROP FOREIGN KEY FK_36FC2E198DB60186');
        $this->addSql('ALTER TABLE flag DROP FOREIGN KEY FK_D1F4EB9AA23B8704');
        $this->addSql('ALTER TABLE workDays DROP FOREIGN KEY FK_7CD31D3EA23B8704');
        $this->addSql('ALTER TABLE completed_task DROP FOREIGN KEY FK_36FC2E196B20BA36');
        $this->addSql('ALTER TABLE work_day DROP FOREIGN KEY FK_9FCE7E0CF675F31B');
        $this->addSql('ALTER TABLE workDays DROP FOREIGN KEY FK_7CD31D3E6B20BA36');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE completed_task');
        $this->addSql('DROP TABLE flag');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE work_day');
        $this->addSql('DROP TABLE worker');
        $this->addSql('DROP TABLE workDays');
    }
}
