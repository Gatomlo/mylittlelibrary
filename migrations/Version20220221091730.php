<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221091730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sample (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_F10B76C316A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sample ADD CONSTRAINT FK_F10B76C316A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book DROP code');
        $this->addSql('ALTER TABLE book_rental DROP FOREIGN KEY FK_3FCEC9F016A2B381');
        $this->addSql('DROP INDEX IDX_3FCEC9F016A2B381 ON book_rental');
        $this->addSql('ALTER TABLE book_rental CHANGE book_id sample_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_rental ADD CONSTRAINT FK_3FCEC9F01B1FEA20 FOREIGN KEY (sample_id) REFERENCES sample (id)');
        $this->addSql('CREATE INDEX IDX_3FCEC9F01B1FEA20 ON book_rental (sample_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_rental DROP FOREIGN KEY FK_3FCEC9F01B1FEA20');
        $this->addSql('DROP TABLE sample');
        $this->addSql('ALTER TABLE book ADD code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_3FCEC9F01B1FEA20 ON book_rental');
        $this->addSql('ALTER TABLE book_rental CHANGE sample_id book_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_rental ADD CONSTRAINT FK_3FCEC9F016A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_3FCEC9F016A2B381 ON book_rental (book_id)');
    }
}
