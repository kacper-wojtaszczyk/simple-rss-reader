<?php

declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021074518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE feed (id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, link CLOB DEFAULT NULL --(DC2Type:object)
        , rights VARCHAR(255) DEFAULT NULL, author CLOB DEFAULT NULL --(DC2Type:object)
        , icon VARCHAR(255) DEFAULT NULL, subtitle VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, updated DATETIME NOT NULL, contributor CLOB DEFAULT NULL --(DC2Type:object)
        , generator VARCHAR(255) DEFAULT NULL, last_fetched DATETIME DEFAULT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE word (word VARCHAR(255) NOT NULL, feed_id VARCHAR(255) NOT NULL, count INTEGER NOT NULL, PRIMARY KEY(word, feed_id))');
        $this->addSql('CREATE INDEX IDX_C3F1751151A5BC03 ON word (feed_id)');
        $this->addSql('CREATE TABLE entry (id VARCHAR(255) NOT NULL, feed_id VARCHAR(255) NOT NULL, updated DATETIME NOT NULL, author CLOB DEFAULT NULL --(DC2Type:object)
        , link CLOB DEFAULT NULL --(DC2Type:object)
        , title VARCHAR(255) NOT NULL, summary CLOB DEFAULT NULL, content CLOB DEFAULT NULL --(DC2Type:object)
        , contributor CLOB DEFAULT NULL --(DC2Type:object)
        , published DATETIME DEFAULT NULL, rights VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id, feed_id))');
        $this->addSql('CREATE INDEX IDX_2B219D7051A5BC03 ON entry (feed_id)');
        $this->addSql('CREATE TABLE category (term VARCHAR(255) NOT NULL, scheme VARCHAR(255) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(term))');
        $this->addSql('CREATE TABLE category_feed (category_term VARCHAR(255) NOT NULL, feed_id VARCHAR(255) NOT NULL, PRIMARY KEY(category_term, feed_id))');
        $this->addSql('CREATE INDEX IDX_A8DB3EEC2E949DCA ON category_feed (category_term)');
        $this->addSql('CREATE INDEX IDX_A8DB3EEC51A5BC03 ON category_feed (feed_id)');
        $this->addSql('CREATE TABLE category_entry (category_term VARCHAR(255) NOT NULL, entry_id VARCHAR(255) NOT NULL, PRIMARY KEY(category_term, entry_id))');
        $this->addSql('CREATE INDEX IDX_C312D2392E949DCA ON category_entry (category_term)');
        $this->addSql('CREATE INDEX IDX_C312D239BA364942 ON category_entry (entry_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:array)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992FC23A8 ON user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A0D96FBF ON user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C05FB297 ON user (confirmation_token)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE feed');
        $this->addSql('DROP TABLE word');
        $this->addSql('DROP TABLE entry');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_feed');
        $this->addSql('DROP TABLE category_entry');
        $this->addSql('DROP TABLE user');
    }
}
