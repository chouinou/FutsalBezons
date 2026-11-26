<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261126154946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__team_member AS SELECT id, user_id_id, team_id_id FROM team_member');
        $this->addSql('DROP TABLE team_member');
        $this->addSql('CREATE TABLE team_member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id_id INTEGER NOT NULL, team_id_id INTEGER NOT NULL, role VARCHAR(20) NOT NULL, CONSTRAINT FK_6FFBDA19D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6FFBDA1B842D717 FOREIGN KEY (team_id_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO team_member (id, user_id_id, team_id_id) SELECT id, user_id_id, team_id_id FROM __temp__team_member');
        $this->addSql('DROP TABLE __temp__team_member');
        $this->addSql('CREATE INDEX IDX_6FFBDA1B842D717 ON team_member (team_id_id)');
        $this->addSql('CREATE INDEX IDX_6FFBDA19D86650F ON team_member (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__team_member AS SELECT id, user_id_id, team_id_id FROM team_member');
        $this->addSql('DROP TABLE team_member');
        $this->addSql('CREATE TABLE team_member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id_id INTEGER NOT NULL, team_id_id INTEGER NOT NULL, season_id_id INTEGER NOT NULL, CONSTRAINT FK_6FFBDA19D86650F FOREIGN KEY (user_id_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6FFBDA1B842D717 FOREIGN KEY (team_id_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6FFBDA168756988 FOREIGN KEY (season_id_id) REFERENCES season (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO team_member (id, user_id_id, team_id_id) SELECT id, user_id_id, team_id_id FROM __temp__team_member');
        $this->addSql('DROP TABLE __temp__team_member');
        $this->addSql('CREATE INDEX IDX_6FFBDA19D86650F ON team_member (user_id_id)');
        $this->addSql('CREATE INDEX IDX_6FFBDA1B842D717 ON team_member (team_id_id)');
        $this->addSql('CREATE INDEX IDX_6FFBDA168756988 ON team_member (season_id_id)');
    }
}
