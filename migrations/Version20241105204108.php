<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241105204108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color_option_value (color_id INT NOT NULL, option_value_id INT NOT NULL, INDEX IDX_2D56D00A7ADA1FB5 (color_id), INDEX IDX_2D56D00AD957CA06 (option_value_id), PRIMARY KEY(color_id, option_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color_product (color_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_80DC89837ADA1FB5 (color_id), INDEX IDX_80DC89834584665A (product_id), PRIMARY KEY(color_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE color_option_value ADD CONSTRAINT FK_2D56D00A7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color_option_value ADD CONSTRAINT FK_2D56D00AD957CA06 FOREIGN KEY (option_value_id) REFERENCES option_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color_product ADD CONSTRAINT FK_80DC89837ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color_product ADD CONSTRAINT FK_80DC89834584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE color ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE color_option_value DROP FOREIGN KEY FK_2D56D00A7ADA1FB5');
        $this->addSql('ALTER TABLE color_option_value DROP FOREIGN KEY FK_2D56D00AD957CA06');
        $this->addSql('ALTER TABLE color_product DROP FOREIGN KEY FK_80DC89837ADA1FB5');
        $this->addSql('ALTER TABLE color_product DROP FOREIGN KEY FK_80DC89834584665A');
        $this->addSql('DROP TABLE color_option_value');
        $this->addSql('DROP TABLE color_product');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE color DROP image');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC ON `user`');
        $this->addSql('ALTER TABLE `user` DROP role_id');
    }
}
