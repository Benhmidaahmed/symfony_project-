<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250129132257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_user_cin');
        $this->addSql('ALTER TABLE appointment CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointment RENAME INDEX fk_user_cin TO IDX_FE38F844A76ED395');
        $this->addSql('ALTER TABLE user CHANGE cin cin VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX cin TO UNIQ_8D93D649ABE530DA');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844A76ED395');
        $this->addSql('ALTER TABLE appointment CHANGE user_id user_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_user_cin FOREIGN KEY (user_id) REFERENCES user (cin) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointment RENAME INDEX idx_fe38f844a76ed395 TO FK_user_cin');
        $this->addSql('ALTER TABLE `user` CHANGE cin cin INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` RENAME INDEX uniq_8d93d649abe530da TO cin');
    }
}
