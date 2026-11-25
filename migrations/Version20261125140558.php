<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261125140558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE events (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(50) NOT NULL, description CLOB DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, status VARCHAR(30) NOT NULL, team_id_id INTEGER DEFAULT NULL, location_id_id INTEGER NOT NULL, created_by_id INTEGER NOT NULL, updated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_5387574AB842D717 FOREIGN KEY (team_id_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574A918DB72 FOREIGN KEY (location_id_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5387574AB842D717 ON events (team_id_id)');
        $this->addSql('CREATE INDEX IDX_5387574A918DB72 ON events (location_id_id)');
        $this->addSql('CREATE INDEX IDX_5387574AB03A8386 ON events (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5387574A896DBBDE ON events (updated_by_id)');
        $this->addSql('CREATE TABLE location (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(150) NOT NULL, adress VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL)');
        $this->addSql('CREATE TABLE membership (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, status VARCHAR(30) NOT NULL, rejection CLOB DEFAULT NULL, medical_check BOOLEAN DEFAULT NULL, user_id_id INTEGER NOT NULL, season_id_id INTEGER NOT NULL, CONSTRAINT FK_86FFD2859D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_86FFD28568756988 FOREIGN KEY (season_id_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_86FFD2859D86650F ON membership (user_id_id)');
        $this->addSql('CREATE INDEX IDX_86FFD28568756988 ON membership (season_id_id)');
        $this->addSql('CREATE TABLE payment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, amount NUMERIC(6, 2) NOT NULL, date DATE NOT NULL, method VARCHAR(30) NOT NULL, status VARCHAR(30) NOT NULL, reference VARCHAR(255) DEFAULT NULL, membership_id_id INTEGER NOT NULL, CONSTRAINT FK_6D28840D7389BA5A FOREIGN KEY (membership_id_id) REFERENCES membership (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6D28840D7389BA5A ON payment (membership_id_id)');
        $this->addSql('CREATE TABLE season (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE team (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(100) NOT NULL, category VARCHAR(50) NOT NULL, season_id_id INTEGER NOT NULL, CONSTRAINT FK_C4E0A61F68756988 FOREIGN KEY (season_id_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F68756988 ON team (season_id_id)');
        $this->addSql('CREATE TABLE team_member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id_id INTEGER NOT NULL, team_id_id INTEGER NOT NULL, season_id_id INTEGER NOT NULL, CONSTRAINT FK_6FFBDA19D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6FFBDA1B842D717 FOREIGN KEY (team_id_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6FFBDA168756988 FOREIGN KEY (season_id_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6FFBDA19D86650F ON team_member (user_id_id)');
        $this->addSql('CREATE INDEX IDX_6FFBDA1B842D717 ON team_member (team_id_id)');
        $this->addSql('CREATE INDEX IDX_6FFBDA168756988 ON team_member (season_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE membership');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_member');
    }
}
