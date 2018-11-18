<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181118205042 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_D34A04AD989D9B62');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, price, description, slug FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, price DOUBLE PRECISION NOT NULL, description CLOB DEFAULT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, image_name VARCHAR(255))');
        $this->addSql('INSERT INTO product (id, name, price, description, slug) SELECT id, name, price, description, slug FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD989D9B62 ON product (slug)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_D34A04AD989D9B62');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, slug, name, description, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO product (id, slug, name, description, price) SELECT id, slug, name, description, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD989D9B62 ON product (slug)');
    }
}
