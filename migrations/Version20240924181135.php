<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924181135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE option_value (id INT AUTO_INCREMENT NOT NULL, optiona_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, additional_price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_249CE55CC0CB9AE5 (optiona_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_value ADD CONSTRAINT FK_249CE55CC0CB9AE5 FOREIGN KEY (optiona_id) REFERENCES `option` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE option_value DROP FOREIGN KEY FK_249CE55CC0CB9AE5');
        $this->addSql('DROP TABLE option_value');
    }
}
