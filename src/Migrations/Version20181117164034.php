<?php declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Product;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181117164034 extends AbstractMigration implements ContainerAwareInterface
{

    /** @var ManagerRegistry $managerRegistry */
    private $managerRegistry;

    /** @var ObjectManager $objectManager */
    private $objectManager;


    public function setContainer(ContainerInterface $container = null): void
    {
        $this->managerRegistry = $container->get('doctrine');
        $this->objectManager = $this->managerRegistry->getManager();
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE product ADD COLUMN slug VARCHAR(255) NOT NULL COLLATE BINARY DEFAULT "";');
    }


    public function postUp(Schema $schema): void
    {
        $productRepository =  $this->managerRegistry->getRepository(Product::class);

        foreach ($productRepository->findAll() as $product){
            $product->setSlug(null);
            $this->objectManager->persist($product);
        }

        $this->objectManager->flush();
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, description, price FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO product (id, name, description, price) SELECT id, name, description, price FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
    }
}
