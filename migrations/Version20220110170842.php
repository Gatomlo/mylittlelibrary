<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110170842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrower (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, implantation VARCHAR(255) DEFAULT NULL, department VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental (id INT AUTO_INCREMENT NOT NULL, borrower_id INT NOT NULL, location_date DATE NOT NULL, return_status TINYINT(1) NOT NULL, term INT NOT NULL, observation LONGTEXT DEFAULT NULL, INDEX IDX_1619C27D11CE312B (borrower_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental_book (rental_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_44A9FCF1A7CF2329 (rental_id), INDEX IDX_44A9FCF116A2B381 (book_id), PRIMARY KEY(rental_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D11CE312B FOREIGN KEY (borrower_id) REFERENCES borrower (id)');
        $this->addSql('ALTER TABLE rental_book ADD CONSTRAINT FK_44A9FCF1A7CF2329 FOREIGN KEY (rental_id) REFERENCES rental (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rental_book ADD CONSTRAINT FK_44A9FCF116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental DROP FOREIGN KEY FK_1619C27D11CE312B');
        $this->addSql('ALTER TABLE rental_book DROP FOREIGN KEY FK_44A9FCF1A7CF2329');
        $this->addSql('DROP TABLE borrower');
        $this->addSql('DROP TABLE rental');
        $this->addSql('DROP TABLE rental_book');
    }
}
