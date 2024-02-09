<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209125549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tariff (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, speed INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD tariff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045592348FD2 FOREIGN KEY (tariff_id) REFERENCES tariff (id)');
        $this->addSql('CREATE INDEX IDX_C744045592348FD2 ON client (tariff_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045592348FD2');
        $this->addSql('DROP TABLE tariff');
        $this->addSql('DROP INDEX IDX_C744045592348FD2 ON client');
        $this->addSql('ALTER TABLE client DROP tariff_id');
    }
}
