<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261125141525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__events AS SELECT id, type, description, start_date, end_date, status, team_id_id, location_id_id, created_by_id, updated_by_id FROM events');
        $this->addSql('DROP TABLE events');
        $this->addSql('CREATE TABLE events (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(50) NOT NULL, description CLOB DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, status VARCHAR(30) NOT NULL, team_id_id INTEGER DEFAULT NULL, location_id_id INTEGER NOT NULL, created_by_id INTEGER NOT NULL, updated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_5387574AB842D717 FOREIGN KEY (team_id_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574A918DB72 FOREIGN KEY (location_id_id) REFERENCES location (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO events (id, type, description, start_date, end_date, status, team_id_id, location_id_id, created_by_id, updated_by_id) SELECT id, type, description, start_date, end_date, status, team_id_id, location_id_id, created_by_id, updated_by_id FROM __temp__events');
        $this->addSql('DROP TABLE __temp__events');
        $this->addSql('CREATE INDEX IDX_5387574A896DBBDE ON events (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_5387574AB03A8386 ON events (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5387574A918DB72 ON events (location_id_id)');
        $this->addSql('CREATE INDEX IDX_5387574AB842D717 ON events (team_id_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, email, password, first_name, last_name, phone, roles, created_at, updated_at, is_active FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(20) NOT NULL, roles CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO users (id, email, password, first_name, last_name, phone, roles, created_at, updated_at, is_active) SELECT id, email, password, first_name, last_name, phone, roles, created_at, updated_at, is_active FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__events AS SELECT id, type, description, start_date, end_date, status, team_id_id, location_id_id, created_by_id, updated_by_id FROM events');
        $this->addSql('DROP TABLE events');
        $this->addSql('CREATE TABLE events (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(50) NOT NULL, description CLOB DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, status VARCHAR(30) NOT NULL, team_id_id INTEGER DEFAULT NULL, location_id_id INTEGER NOT NULL, created_by_id INTEGER NOT NULL, updated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_5387574AB842D717 FOREIGN KEY (team_id_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574A918DB72 FOREIGN KEY (location_id_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5387574A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO events (id, type, description, start_date, end_date, status, team_id_id, location_id_id, created_by_id, updated_by_id) SELECT id, type, description, start_date, end_date, status, team_id_id, location_id_id, created_by_id, updated_by_id FROM __temp__events');
        $this->addSql('DROP TABLE __temp__events');
        $this->addSql('CREATE INDEX IDX_5387574AB842D717 ON events (team_id_id)');
        $this->addSql('CREATE INDEX IDX_5387574A918DB72 ON events (location_id_id)');
        $this->addSql('CREATE INDEX IDX_5387574AB03A8386 ON events (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5387574A896DBBDE ON events (updated_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, email, password, first_name, last_name, phone, roles, created_at, updated_at, is_active FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, phone VARCHAR(20) NOT NULL, roles CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO users (id, email, password, first_name, last_name, phone, roles, created_at, updated_at, is_active) SELECT id, email, password, first_name, last_name, phone, roles, created_at, updated_at, is_active FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
    }
}
