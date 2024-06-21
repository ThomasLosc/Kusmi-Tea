<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621073445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD frequencethe VARCHAR(255) NOT NULL, ADD quel_the VARCHAR(255) NOT NULL, ADD quel_gout VARCHAR(255) NOT NULL, ADD autre_type_the VARCHAR(255) NOT NULL, ADD comment_connu_kusmi_tea VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP frequencethe, DROP quel_the, DROP quel_gout, DROP autre_type_the, DROP comment_connu_kusmi_tea');
    }
}
