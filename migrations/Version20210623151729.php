<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623151729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE orderHasProducts ADD sale_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orderHasProducts ADD CONSTRAINT FK_D34A04AD4A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4A7E4868 ON orderHasProducts (sale_id)');
        $this->addSql('ALTER TABLE tag ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderHasProducts DROP FOREIGN KEY FK_D34A04AD4A7E4868');
        $this->addSql('DROP TABLE sale');
        $this->addSql('ALTER TABLE category DROP created_at');
        $this->addSql('DROP INDEX IDX_D34A04AD4A7E4868 ON orderHasProducts');
        $this->addSql('ALTER TABLE orderHasProducts DROP sale_id');
        $this->addSql('ALTER TABLE tag DROP created_at');
    }
}
