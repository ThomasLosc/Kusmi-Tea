<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619140402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD adresse_id INT DEFAULT NULL, DROP ville, DROP code_postal, DROP adresse, DROP nom_adresse, DROP prenom_adresse, DROP complement_adresse, DROP telephone_adresse');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494DE7DC5C ON user (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494DE7DC5C');
        $this->addSql('DROP INDEX IDX_8D93D6494DE7DC5C ON `user`');
        $this->addSql('ALTER TABLE `user` ADD ville VARCHAR(255) DEFAULT NULL, ADD code_postal VARCHAR(255) DEFAULT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, ADD nom_adresse VARCHAR(255) DEFAULT NULL, ADD prenom_adresse VARCHAR(255) DEFAULT NULL, ADD complement_adresse VARCHAR(255) DEFAULT NULL, ADD telephone_adresse VARCHAR(255) DEFAULT NULL, DROP adresse_id');
    }
}
