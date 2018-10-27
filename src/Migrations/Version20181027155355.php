<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181027155355 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP INDEX name ON role');
        $this->addSql('ALTER TABLE role CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE last_name last_name VARCHAR(64) NOT NULL, CHANGE first_name first_name VARCHAR(64) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX email TO UNIQ_8D93D649E7927C74');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_role (id INT NOT NULL, user_id INT DEFAULT NULL, role_id INT DEFAULT NULL, INDEX user_id (user_id), INDEX role_id (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT user_role_ibfk_1 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT user_role_ibfk_2 FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE role CHANGE id id INT NOT NULL, CHANGE name name VARCHAR(64) DEFAULT NULL COLLATE latin1_swedish_ci');
        $this->addSql('CREATE UNIQUE INDEX name ON role (name)');
        $this->addSql('ALTER TABLE user DROP roles, CHANGE id id INT NOT NULL, CHANGE email email VARCHAR(64) DEFAULT NULL COLLATE latin1_swedish_ci, CHANGE password password VARCHAR(256) DEFAULT NULL COLLATE latin1_swedish_ci, CHANGE last_name last_name VARCHAR(64) DEFAULT NULL COLLATE latin1_swedish_ci, CHANGE first_name first_name VARCHAR(64) DEFAULT NULL COLLATE latin1_swedish_ci');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649e7927c74 TO email');
    }
}
