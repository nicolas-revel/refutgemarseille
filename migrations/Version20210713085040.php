<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210713085040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP INDEX UNIQ_794381C64584665A, ADD INDEX IDX_794381C64584665A (product_id)');
        $this->addSql('ALTER TABLE review CHANGE product_id product_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP INDEX IDX_794381C64584665A, ADD UNIQUE INDEX UNIQ_794381C64584665A (product_id)');
        $this->addSql('ALTER TABLE review CHANGE product_id product_id INT DEFAULT NULL');
    }
}
