<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627083431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE point_log (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, label VARCHAR(255) NOT NULL, points INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_DCF3EA5CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referral (id INT AUTO_INCREMENT NOT NULL, referrer_id INT NOT NULL, referred_id INT NOT NULL, INDEX IDX_73079D00798C22DB (referrer_id), INDEX IDX_73079D00CFE2A98 (referred_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referral_code (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6447454A77153098 (code), INDEX IDX_6447454AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE point_log ADD CONSTRAINT FK_DCF3EA5CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE referral ADD CONSTRAINT FK_73079D00798C22DB FOREIGN KEY (referrer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE referral ADD CONSTRAINT FK_73079D00CFE2A98 FOREIGN KEY (referred_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE referral_code ADD CONSTRAINT FK_6447454AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user ADD points INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point_log DROP FOREIGN KEY FK_DCF3EA5CA76ED395');
        $this->addSql('ALTER TABLE referral DROP FOREIGN KEY FK_73079D00798C22DB');
        $this->addSql('ALTER TABLE referral DROP FOREIGN KEY FK_73079D00CFE2A98');
        $this->addSql('ALTER TABLE referral_code DROP FOREIGN KEY FK_6447454AA76ED395');
        $this->addSql('DROP TABLE point_log');
        $this->addSql('DROP TABLE referral');
        $this->addSql('DROP TABLE referral_code');
        $this->addSql('ALTER TABLE `user` DROP points');
    }
}
