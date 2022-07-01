<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627214148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE portion_frite_menu (portion_frite_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_85CB0C2D9B17FA7B (portion_frite_id), INDEX IDX_85CB0C2DCCD7E912 (menu_id), PRIMARY KEY(portion_frite_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE portion_frite_menu ADD CONSTRAINT FK_85CB0C2D9B17FA7B FOREIGN KEY (portion_frite_id) REFERENCES portion_frite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portion_frite_menu ADD CONSTRAINT FK_85CB0C2DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE portion_frite_menu');
    }
}
