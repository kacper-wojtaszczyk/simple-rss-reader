<?php

declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191016061227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__feed AS SELECT id, title, links, rights, author, icon, subtitle, logo, updated, contributor, generator, last_fetched FROM feed');
        $this->addSql('DROP TABLE feed');
        $this->addSql('CREATE TABLE feed (id VARCHAR(255) NOT NULL COLLATE BINARY, title VARCHAR(255) NOT NULL COLLATE BINARY, rights VARCHAR(255) DEFAULT NULL COLLATE BINARY, author CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:json)
        , icon VARCHAR(255) DEFAULT NULL COLLATE BINARY, subtitle VARCHAR(255) DEFAULT NULL COLLATE BINARY, logo VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated DATETIME NOT NULL, contributor CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:json)
        , generator VARCHAR(255) DEFAULT NULL COLLATE BINARY, last_fetched DATETIME DEFAULT NULL, link CLOB DEFAULT NULL --(DC2Type:json)
        , url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO feed (id, title, link, rights, author, icon, subtitle, logo, updated, contributor, generator, last_fetched) SELECT id, title, links, rights, author, icon, subtitle, logo, updated, contributor, generator, last_fetched FROM __temp__feed');
        $this->addSql('DROP TABLE __temp__feed');
        $this->addSql('DROP INDEX IDX_2B219D7051A5BC03');
        $this->addSql('CREATE TEMPORARY TABLE __temp__entry AS SELECT id, feed_id, updated, author, link, title, summary, content, contributor, published, rights FROM entry');
        $this->addSql('DROP TABLE entry');
        $this->addSql('CREATE TABLE entry (id VARCHAR(255) NOT NULL COLLATE BINARY, feed_id VARCHAR(255) NOT NULL COLLATE BINARY, updated DATETIME NOT NULL, author CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:json)
        , link CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:json)
        , title VARCHAR(255) NOT NULL COLLATE BINARY, summary CLOB DEFAULT NULL COLLATE BINARY, content CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:json)
        , contributor CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:json)
        , published DATETIME DEFAULT NULL, rights VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id, feed_id), CONSTRAINT FK_2B219D7051A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO entry (id, feed_id, updated, author, link, title, summary, content, contributor, published, rights) SELECT id, feed_id, updated, author, link, title, summary, content, contributor, published, rights FROM __temp__entry');
        $this->addSql('DROP TABLE __temp__entry');
        $this->addSql('CREATE INDEX IDX_2B219D7051A5BC03 ON entry (feed_id)');
        $this->addSql('DROP INDEX IDX_A8DB3EEC51A5BC03');
        $this->addSql('DROP INDEX IDX_A8DB3EEC2E949DCA');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_feed AS SELECT category_term, feed_id FROM category_feed');
        $this->addSql('DROP TABLE category_feed');
        $this->addSql('CREATE TABLE category_feed (category_term VARCHAR(255) NOT NULL COLLATE BINARY, feed_id VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(category_term, feed_id), CONSTRAINT FK_A8DB3EEC2E949DCA FOREIGN KEY (category_term) REFERENCES category (term) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A8DB3EEC51A5BC03 FOREIGN KEY (feed_id) REFERENCES feed (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_feed (category_term, feed_id) SELECT category_term, feed_id FROM __temp__category_feed');
        $this->addSql('DROP TABLE __temp__category_feed');
        $this->addSql('CREATE INDEX IDX_A8DB3EEC51A5BC03 ON category_feed (feed_id)');
        $this->addSql('CREATE INDEX IDX_A8DB3EEC2E949DCA ON category_feed (category_term)');
        $this->addSql('DROP INDEX IDX_C312D239BA364942');
        $this->addSql('DROP INDEX IDX_C312D2392E949DCA');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_entry AS SELECT category_term, entry_id FROM category_entry');
        $this->addSql('DROP TABLE category_entry');
        $this->addSql('CREATE TABLE category_entry (category_term VARCHAR(255) NOT NULL COLLATE BINARY, entry_id VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(category_term, entry_id), CONSTRAINT FK_C312D2392E949DCA FOREIGN KEY (category_term) REFERENCES category (term) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C312D239BA364942 FOREIGN KEY (entry_id) REFERENCES entry (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_entry (category_term, entry_id) SELECT category_term, entry_id FROM __temp__category_entry');
        $this->addSql('DROP TABLE __temp__category_entry');
        $this->addSql('CREATE INDEX IDX_C312D239BA364942 ON category_entry (entry_id)');
        $this->addSql('CREATE INDEX IDX_C312D2392E949DCA ON category_entry (category_term)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_C312D2392E949DCA');
        $this->addSql('DROP INDEX IDX_C312D239BA364942');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_entry AS SELECT category_term, entry_id FROM category_entry');
        $this->addSql('DROP TABLE category_entry');
        $this->addSql('CREATE TABLE category_entry (category_term VARCHAR(255) NOT NULL, entry_id VARCHAR(255) NOT NULL, PRIMARY KEY(category_term, entry_id))');
        $this->addSql('INSERT INTO category_entry (category_term, entry_id) SELECT category_term, entry_id FROM __temp__category_entry');
        $this->addSql('DROP TABLE __temp__category_entry');
        $this->addSql('CREATE INDEX IDX_C312D2392E949DCA ON category_entry (category_term)');
        $this->addSql('CREATE INDEX IDX_C312D239BA364942 ON category_entry (entry_id)');
        $this->addSql('DROP INDEX IDX_A8DB3EEC2E949DCA');
        $this->addSql('DROP INDEX IDX_A8DB3EEC51A5BC03');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_feed AS SELECT category_term, feed_id FROM category_feed');
        $this->addSql('DROP TABLE category_feed');
        $this->addSql('CREATE TABLE category_feed (category_term VARCHAR(255) NOT NULL, feed_id VARCHAR(255) NOT NULL, PRIMARY KEY(category_term, feed_id))');
        $this->addSql('INSERT INTO category_feed (category_term, feed_id) SELECT category_term, feed_id FROM __temp__category_feed');
        $this->addSql('DROP TABLE __temp__category_feed');
        $this->addSql('CREATE INDEX IDX_A8DB3EEC2E949DCA ON category_feed (category_term)');
        $this->addSql('CREATE INDEX IDX_A8DB3EEC51A5BC03 ON category_feed (feed_id)');
        $this->addSql('DROP INDEX IDX_2B219D7051A5BC03');
        $this->addSql('CREATE TEMPORARY TABLE __temp__entry AS SELECT id, feed_id, updated, author, link, title, summary, content, contributor, published, rights FROM entry');
        $this->addSql('DROP TABLE entry');
        $this->addSql('CREATE TABLE entry (id VARCHAR(255) NOT NULL, feed_id VARCHAR(255) NOT NULL, updated DATETIME NOT NULL, author CLOB DEFAULT NULL --(DC2Type:json)
        , link CLOB DEFAULT NULL --(DC2Type:json)
        , title VARCHAR(255) NOT NULL, summary CLOB DEFAULT NULL, content CLOB DEFAULT NULL --(DC2Type:json)
        , contributor CLOB DEFAULT NULL --(DC2Type:json)
        , published DATETIME DEFAULT NULL, rights VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id, feed_id))');
        $this->addSql('INSERT INTO entry (id, feed_id, updated, author, link, title, summary, content, contributor, published, rights) SELECT id, feed_id, updated, author, link, title, summary, content, contributor, published, rights FROM __temp__entry');
        $this->addSql('DROP TABLE __temp__entry');
        $this->addSql('CREATE INDEX IDX_2B219D7051A5BC03 ON entry (feed_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__feed AS SELECT id, title, link, rights, author, icon, subtitle, logo, updated, contributor, generator, last_fetched FROM feed');
        $this->addSql('DROP TABLE feed');
        $this->addSql('CREATE TABLE feed (id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, rights VARCHAR(255) DEFAULT NULL, author CLOB DEFAULT NULL --(DC2Type:json)
        , icon VARCHAR(255) DEFAULT NULL, subtitle VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, updated DATETIME NOT NULL, contributor CLOB DEFAULT NULL --(DC2Type:json)
        , generator VARCHAR(255) DEFAULT NULL, last_fetched DATETIME DEFAULT NULL, links CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:json)
        , PRIMARY KEY(id))');
        $this->addSql('INSERT INTO feed (id, title, links, rights, author, icon, subtitle, logo, updated, contributor, generator, last_fetched) SELECT id, title, link, rights, author, icon, subtitle, logo, updated, contributor, generator, last_fetched FROM __temp__feed');
        $this->addSql('DROP TABLE __temp__feed');
    }
}
