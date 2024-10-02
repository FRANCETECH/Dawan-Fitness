<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221007123421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change primary key on table permissions_structures';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions_structures MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON permissions_structures');
        $this->addSql('ALTER TABLE permissions_structures DROP id');
        $this->addSql('ALTER TABLE permissions_structures ADD PRIMARY KEY (permissions_id, structures_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions_structures ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
