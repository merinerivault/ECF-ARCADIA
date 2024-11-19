<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241112144212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_rendu_veterinaire ADD veterinaire_id INT NOT NULL, ADD rapport LONGTEXT NOT NULL, ADD date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE compte_rendu_veterinaire ADD CONSTRAINT FK_DE92162E5C80924 FOREIGN KEY (veterinaire_id) REFERENCES veterinaire (id)');
        $this->addSql('CREATE INDEX IDX_DE92162E5C80924 ON compte_rendu_veterinaire (veterinaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_rendu_veterinaire DROP FOREIGN KEY FK_DE92162E5C80924');
        $this->addSql('DROP INDEX IDX_DE92162E5C80924 ON compte_rendu_veterinaire');
        $this->addSql('ALTER TABLE compte_rendu_veterinaire DROP veterinaire_id, DROP rapport, DROP date');
    }
}
