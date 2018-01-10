<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180110134652 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE search CHANGE country country TINYTEXT DEFAULT NULL, CHANGE datacenter datacenter TINYTEXT DEFAULT NULL, CHANGE device device INT DEFAULT NULL, CHANGE local local TINYTEXT DEFAULT NULL, CHANGE parameters parameters LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE search CHANGE country country TINYTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE datacenter datacenter TINYTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE device device INT NOT NULL, CHANGE local local TINYTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE parameters parameters LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
    }
}
