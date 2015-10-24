<?php

namespace Application\Migrations;

use AppBundle\DataFixtures\ORM\LoadBusinessServicesData;
use AppBundle\EmailImporter\EmailImporter;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151017164455 extends AbstractMigration implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function postUp(Schema $schema)
    {
        // add services
        $servicesLoader = new LoadBusinessServicesData();
        $manager = $this->container->get("doctrine.orm.quotation_request_manager");
        $servicesLoader->load($manager->getDoctrineDefaultManager());

        // imports quotation request
     /*   $emailImporter = new EmailImporter(__DIR__."/../../web/emails");
        $this->write(sprintf('start loading %s entities...', $emailImporter->getNbFiles()));
        $entities = $emailImporter->loadEntities();
        if (count($entities) > 0) {
            $this->write(sprintf('start persisitng %s entities...', $emailImporter->getNbFiles()));

            $errors = $emailImporter->getErrorLog();
            if (count($errors)) {
                foreach ($errors as $err) {
                    $this->write($err);
                }
            }
            foreach ($entities as $entity) {
                $manager->persistAndFlush($entity);
            }
            $manager->flush();
        } else {
            $this->write("No file found");
        }*/

        //photos ??
    }


    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE QuotationRequestServiceRelation (id INT AUTO_INCREMENT NOT NULL, quotation_request_id INT NOT NULL, business_service_ref VARCHAR(255) NOT NULL, INDEX IDX_9F9D69167EECC807 (quotation_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE BusinessService (id INT AUTO_INCREMENT NOT NULL, ref VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_47635A9146F3EA3 (ref), UNIQUE INDEX UNIQ_47635A9989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE QuotationRequest (id INT AUTO_INCREMENT NOT NULL, vehicle_model VARCHAR(255) NOT NULL, problem_description LONGTEXT NOT NULL, has_shelter TINYINT(1) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(512) NOT NULL, town VARCHAR(255) DEFAULT NULL, postal_code INT DEFAULT NULL, contact_origin ENUM(\'OT\', \'IS\', \'SL\', \'YP\', \'WM\', \'CD\', \'FL\') NOT NULL COMMENT \'(DC2Type:ContactOriginEnumType)\', created DATETIME NOT NULL, status ENUM(\'NEW\', \'SCH\', \'PEND\', \'CHAR\', \'CASH\', \'CAN\') NOT NULL COMMENT \'(DC2Type:QuotationRequestStatusEnumType)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_site (id INT AUTO_INCREMENT NOT NULL, vehicle_model VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, carousel_order INT NOT NULL, location VARCHAR(255) NOT NULL, damage_type VARCHAR(255) NOT NULL, business_service_ref VARCHAR(255) NOT NULL, visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE QuotationRequestServiceRelation ADD CONSTRAINT FK_9F9D69167EECC807 FOREIGN KEY (quotation_request_id) REFERENCES QuotationRequest (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE QuotationRequestServiceRelation DROP FOREIGN KEY FK_9F9D69167EECC807');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE QuotationRequestServiceRelation');
        $this->addSql('DROP TABLE BusinessService');
        $this->addSql('DROP TABLE QuotationRequest');
        $this->addSql('DROP TABLE image_site');
    }
}
