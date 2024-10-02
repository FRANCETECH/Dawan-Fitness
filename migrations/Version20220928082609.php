<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220928082609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables permissions, structures, users, users_structures, users_permissions and structures_permissions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE permissions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structures (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, address VARCHAR(100) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structures_permissions (structures_id INT NOT NULL, permissions_id INT NOT NULL, INDEX IDX_15DA28EF9D3ED38D (structures_id), INDEX IDX_15DA28EF9C3E4F87 (permissions_id), PRIMARY KEY(structures_id, permissions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(50) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_structures (users_id INT NOT NULL, structures_id INT NOT NULL, INDEX IDX_8CD56ACE67B3B43D (users_id), INDEX IDX_8CD56ACE9D3ED38D (structures_id), PRIMARY KEY(users_id, structures_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_permissions (users_id INT NOT NULL, permissions_id INT NOT NULL, INDEX IDX_DA58F09D67B3B43D (users_id), INDEX IDX_DA58F09D9C3E4F87 (permissions_id), PRIMARY KEY(users_id, permissions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE structures_permissions ADD CONSTRAINT FK_15DA28EF9D3ED38D FOREIGN KEY (structures_id) REFERENCES structures (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structures_permissions ADD CONSTRAINT FK_15DA28EF9C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_structures ADD CONSTRAINT FK_8CD56ACE67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_structures ADD CONSTRAINT FK_8CD56ACE9D3ED38D FOREIGN KEY (structures_id) REFERENCES structures (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_permissions ADD CONSTRAINT FK_DA58F09D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_permissions ADD CONSTRAINT FK_DA58F09D9C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE structures_permissions DROP FOREIGN KEY FK_15DA28EF9D3ED38D');
        $this->addSql('ALTER TABLE structures_permissions DROP FOREIGN KEY FK_15DA28EF9C3E4F87');
        $this->addSql('ALTER TABLE users_structures DROP FOREIGN KEY FK_8CD56ACE67B3B43D');
        $this->addSql('ALTER TABLE users_structures DROP FOREIGN KEY FK_8CD56ACE9D3ED38D');
        $this->addSql('ALTER TABLE users_permissions DROP FOREIGN KEY FK_DA58F09D67B3B43D');
        $this->addSql('ALTER TABLE users_permissions DROP FOREIGN KEY FK_DA58F09D9C3E4F87');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE structures');
        $this->addSql('DROP TABLE structures_permissions');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_structures');
        $this->addSql('DROP TABLE users_permissions');
    }
}
