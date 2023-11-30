<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129191858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE incoming_message (id INT NOT NULL, subject VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, sender VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, handled DATETIME DEFAULT NULL, handler VARCHAR(255) DEFAULT NULL, messageobject VARCHAR(255) NOT NULL, INDEX IDX_B6BD307FC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outgoing_message (id INT NOT NULL, subject VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, sender VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_message (id INT NOT NULL, subject VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, sender VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incoming_message ADD CONSTRAINT FK_B36C239DBF396750 FOREIGN KEY (id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC54C8C93 FOREIGN KEY (type_id) REFERENCES message_type (id)');
        $this->addSql('ALTER TABLE outgoing_message ADD CONSTRAINT FK_CF2CA896BF396750 FOREIGN KEY (id) REFERENCES message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_message ADD CONSTRAINT FK_A95C1A95BF396750 FOREIGN KEY (id) REFERENCES message (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incoming_message DROP FOREIGN KEY FK_B36C239DBF396750');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FC54C8C93');
        $this->addSql('ALTER TABLE outgoing_message DROP FOREIGN KEY FK_CF2CA896BF396750');
        $this->addSql('ALTER TABLE task_message DROP FOREIGN KEY FK_A95C1A95BF396750');
        $this->addSql('DROP TABLE incoming_message');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_type');
        $this->addSql('DROP TABLE outgoing_message');
        $this->addSql('DROP TABLE task_message');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
