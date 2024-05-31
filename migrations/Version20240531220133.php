<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531220133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaires CHANGE numero_rue_formulaire numero_rue_formulaire INT DEFAULT NULL, CHANGE rue_formulaire rue_formulaire VARCHAR(255) DEFAULT NULL, CHANGE code_postal_formulaire code_postal_formulaire VARCHAR(10) DEFAULT NULL, CHANGE ville_formulaire ville_formulaire VARCHAR(30) DEFAULT NULL, CHANGE pays_formulaire pays_formulaire VARCHAR(30) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaires CHANGE numero_rue_formulaire numero_rue_formulaire INT NOT NULL, CHANGE rue_formulaire rue_formulaire VARCHAR(255) NOT NULL, CHANGE code_postal_formulaire code_postal_formulaire VARCHAR(10) NOT NULL, CHANGE ville_formulaire ville_formulaire VARCHAR(30) NOT NULL, CHANGE pays_formulaire pays_formulaire VARCHAR(30) NOT NULL');
    }
}
