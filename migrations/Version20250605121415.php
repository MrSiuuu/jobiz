<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605121415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, type_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, remote_allowed TINYINT(1) NOT NULL, salary_range VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_FBD8E0F8979B1AD6 (company_id), INDEX IDX_FBD8E0F8C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE job_job_category (job_id INT NOT NULL, job_category_id INT NOT NULL, INDEX IDX_6E682995BE04EA9 (job_id), INDEX IDX_6E682995712A86AB (job_category_id), PRIMARY KEY(job_id, job_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE job_application (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, job_id INT NOT NULL, cover_letter LONGTEXT NOT NULL, create_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_C737C688A76ED395 (user_id), INDEX IDX_C737C688BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE job_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE job_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8C54C8C93 FOREIGN KEY (type_id) REFERENCES job_type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_job_category ADD CONSTRAINT FK_6E682995BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_job_category ADD CONSTRAINT FK_6E682995712A86AB FOREIGN KEY (job_category_id) REFERENCES job_category (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_application ADD CONSTRAINT FK_C737C688A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_application ADD CONSTRAINT FK_C737C688BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8979B1AD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8C54C8C93
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_job_category DROP FOREIGN KEY FK_6E682995BE04EA9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_job_category DROP FOREIGN KEY FK_6E682995712A86AB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_application DROP FOREIGN KEY FK_C737C688A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job_application DROP FOREIGN KEY FK_C737C688BE04EA9
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE company
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE job
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE job_job_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE job_application
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE job_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE job_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
