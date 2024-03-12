<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308192733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendrier (id_calendrier INT AUTO_INCREMENT NOT NULL, titre_calendrier VARCHAR(100) NOT NULL, debut_calendrier DATETIME NOT NULL, fin_calendrier DATETIME NOT NULL, description_calendrier LONGTEXT DEFAULT NULL, couleur_fond_calendrier VARCHAR(7) DEFAULT NULL, couleur_bordure_calendrier VARCHAR(7) DEFAULT NULL, couleur_texte_calendrier VARCHAR(7) DEFAULT NULL, places_disponibles_calendrier INT DEFAULT NULL, nombre_total_places_calendrier INT DEFAULT NULL, PRIMARY KEY(id_calendrier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dons (id_don INT AUTO_INCREMENT NOT NULL, nom_don VARCHAR(50) NOT NULL, prenom_don VARCHAR(50) NOT NULL, telephone_don VARCHAR(15) NOT NULL, email_don VARCHAR(100) NOT NULL, numero_rue_don INT NOT NULL, libelle_rue_don VARCHAR(255) NOT NULL, code_postal_don VARCHAR(10) NOT NULL, ville_don VARCHAR(30) NOT NULL, pays_don VARCHAR(30) NOT NULL, montant_don INT NOT NULL, monnaie_don VARCHAR(3) NOT NULL, stripe_transaction_id_don VARCHAR(255) DEFAULT NULL, paiement_statut_don VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id_don)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formulaires (id_formulaire INT AUTO_INCREMENT NOT NULL, calendrier_id INT DEFAULT NULL, nom_formulaire VARCHAR(30) NOT NULL, prenom_formulaire VARCHAR(30) NOT NULL, telephone_formulaire VARCHAR(15) NOT NULL, email_formulaire VARCHAR(100) NOT NULL, numero_rue_formulaire INT NOT NULL, rue_formulaire VARCHAR(255) NOT NULL, code_postal_formulaire VARCHAR(10) NOT NULL, ville_formulaire VARCHAR(30) NOT NULL, pays_formulaire VARCHAR(30) NOT NULL, nombre_participants_formulaire INT DEFAULT NULL, nom_facturation_formulaire VARCHAR(255) DEFAULT NULL, INDEX IDX_C35839D0FF52FC51 (calendrier_id), PRIMARY KEY(id_formulaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informations_pensionnaires (id_information_pensionnaire INT AUTO_INCREMENT NOT NULL, pensionnaire_id INT DEFAULT NULL, nourriture_information_pensionnaire LONGTEXT DEFAULT NULL, soin_information_pensionnaire LONGTEXT DEFAULT NULL, carnet_de_sante_information_pensionnaire LONGTEXT DEFAULT NULL, histoire_information_pensionnaire LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_62AF3EA930551365 (pensionnaire_id), PRIMARY KEY(id_information_pensionnaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pensionnaires (id_pensionnaire INT AUTO_INCREMENT NOT NULL, nom_pensionnaire VARCHAR(50) DEFAULT NULL, type_pensionnaire VARCHAR(50) DEFAULT NULL, date_de_naissance_pensionnaire DATE DEFAULT NULL, image_pensionnaire VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id_pensionnaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id_utilisateurs INT AUTO_INCREMENT NOT NULL, email_utilisateurs VARCHAR(180) NOT NULL, role_utilisateur JSON NOT NULL, mot_de_passe_utilisateur VARCHAR(255) NOT NULL, nom_utilisateur VARCHAR(25) NOT NULL, prenom_utilisateur VARCHAR(25) NOT NULL, numero_telephone_utilisateur VARCHAR(15) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_497B315E1C68D70D (email_utilisateurs), PRIMARY KEY(id_utilisateurs)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos (id INT AUTO_INCREMENT NOT NULL, titre_video VARCHAR(100) DEFAULT NULL, lien_video VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formulaires ADD CONSTRAINT FK_C35839D0FF52FC51 FOREIGN KEY (calendrier_id) REFERENCES calendrier (id_calendrier)');
        $this->addSql('ALTER TABLE informations_pensionnaires ADD CONSTRAINT FK_62AF3EA930551365 FOREIGN KEY (pensionnaire_id) REFERENCES pensionnaires (id_pensionnaire)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaires DROP FOREIGN KEY FK_C35839D0FF52FC51');
        $this->addSql('ALTER TABLE informations_pensionnaires DROP FOREIGN KEY FK_62AF3EA930551365');
        $this->addSql('DROP TABLE calendrier');
        $this->addSql('DROP TABLE dons');
        $this->addSql('DROP TABLE formulaires');
        $this->addSql('DROP TABLE informations_pensionnaires');
        $this->addSql('DROP TABLE pensionnaires');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE videos');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
