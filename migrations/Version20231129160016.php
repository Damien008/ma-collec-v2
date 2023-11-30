<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129160016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute les types de supports';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO support (name) VALUES ('DVD'), ('Blu-Ray'), ('Blu-Ray 4K'), ('HD-DVD'), ('DivX'), ('VHS'), ('Laser Disc'), ('Blu-Ray 3D');");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM support;');
    }
}
