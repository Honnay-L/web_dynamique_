<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110163127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addfirstname (id INT AUTO_INCREMENT NOT NULL, origin_id INT NOT NULL, date DATETIME NOT NULL, description LONGTEXT NOT NULL, firstname VARCHAR(255) NOT NULL, INDEX IDX_958ABD7E56A273CC (origin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE firstname (id INT AUTO_INCREMENT NOT NULL, origin_id INT DEFAULT NULL, date DATETIME NOT NULL, firstname VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_83A00E6856A273CC (origin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, number INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE origin (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE problem (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usersite (id INT AUTO_INCREMENT NOT NULL, photo_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CF3E7195E7927C74 (email), UNIQUE INDEX UNIQ_CF3E71957E9E4C8C (photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addfirstname ADD CONSTRAINT FK_958ABD7E56A273CC FOREIGN KEY (origin_id) REFERENCES origin (id)');
        $this->addSql('ALTER TABLE firstname ADD CONSTRAINT FK_83A00E6856A273CC FOREIGN KEY (origin_id) REFERENCES origin (id)');
        $this->addSql('ALTER TABLE usersite ADD CONSTRAINT FK_CF3E71957E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE addfirstname DROP FOREIGN KEY FK_958ABD7E56A273CC');
        $this->addSql('ALTER TABLE firstname DROP FOREIGN KEY FK_83A00E6856A273CC');
        $this->addSql('ALTER TABLE usersite DROP FOREIGN KEY FK_CF3E71957E9E4C8C');
        $this->addSql('DROP TABLE addfirstname');
        $this->addSql('DROP TABLE firstname');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE origin');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE problem');
        $this->addSql('DROP TABLE usersite');
    }
}
