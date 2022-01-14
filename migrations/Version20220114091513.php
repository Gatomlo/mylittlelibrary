<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114091513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_rental (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, rental_id INT DEFAULT NULL, due_date DATE NOT NULL, return_date DATE DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_3FCEC9F016A2B381 (book_id), INDEX IDX_3FCEC9F0A7CF2329 (rental_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_rental ADD CONSTRAINT FK_3FCEC9F016A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_rental ADD CONSTRAINT FK_3FCEC9F0A7CF2329 FOREIGN KEY (rental_id) REFERENCES rental (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book_rental');
    }
}
