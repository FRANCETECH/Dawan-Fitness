<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007123706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change primary key on table permissions_users';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions_users MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON permissions_users');
        $this->addSql('ALTER TABLE permissions_users DROP id');
        $this->addSql('ALTER TABLE permissions_users ADD PRIMARY KEY (permissions_id, users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions_users ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
