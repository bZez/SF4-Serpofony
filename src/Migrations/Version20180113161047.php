<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180113161047 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE run (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, rank_id INT DEFAULT NULL, module_id INT DEFAULT NULL, day DATE DEFAULT NULL, started DATETIME DEFAULT NULL, finished DATETIME DEFAULT NULL, progress INT DEFAULT NULL, captchas INT DEFAULT NULL, errors INT DEFAULT NULL, status INT DEFAULT NULL, mode INT DEFAULT NULL, INDEX IDX_5076A4C0FE54D947 (group_id), INDEX IDX_5076A4C07616678F (rank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE run ADD CONSTRAINT FK_5076A4C0FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE run ADD CONSTRAINT FK_5076A4C07616678F FOREIGN KEY (rank_id) REFERENCES rank (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE run');
    }
}
