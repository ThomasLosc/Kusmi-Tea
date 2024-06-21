<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621074159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE frequencethe frequencethe VARCHAR(255) DEFAULT NULL, CHANGE quel_the quel_the VARCHAR(255) DEFAULT NULL, CHANGE quel_gout quel_gout VARCHAR(255) DEFAULT NULL, CHANGE autre_type_the autre_type_the VARCHAR(255) DEFAULT NULL, CHANGE comment_connu_kusmi_tea comment_connu_kusmi_tea VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` CHANGE frequencethe frequencethe VARCHAR(255) NOT NULL, CHANGE quel_the quel_the VARCHAR(255) NOT NULL, CHANGE autre_type_the autre_type_the VARCHAR(255) NOT NULL, CHANGE quel_gout quel_gout VARCHAR(255) NOT NULL, CHANGE comment_connu_kusmi_tea comment_connu_kusmi_tea VARCHAR(255) NOT NULL');
    }
}
