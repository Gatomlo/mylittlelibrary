<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221103122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rental_book');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rental_book (rental_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_44A9FCF1A7CF2329 (rental_id), INDEX IDX_44A9FCF116A2B381 (book_id), PRIMARY KEY(rental_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE rental_book ADD CONSTRAINT FK_44A9FCF116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rental_book ADD CONSTRAINT FK_44A9FCF1A7CF2329 FOREIGN KEY (rental_id) REFERENCES rental (id) ON DELETE CASCADE');
    }
}
