<?php

namespace App\Controller\Admin\Product;

use App\Controller\Admin\AbstractCrudController;
use App\Model\Image\Entity\Image\Image;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use App\Model\Product\UseCase as UseCase;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class ImageCrudController extends AbstractCrudController
{
    public $entityManager;
    public $createHandler;

    public function __construct(
        EntityManagerInterface $entityManager,
        UseCase\Product\Images\Create\Handler $createHandler
    )
    {
        $this->entityManager = $entityManager;
        $this->createHandler = $createHandler;
    }

    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $query = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (isset($_GET['product_id'])) {
            $query->innerJoin('entity.products', 'p')->andWhere('p.id = :id')
                ->setParameter(':id', $_GET['product_id']);
        }

        return $query;
    }

    public function getNewCommand()
    {
        return new UseCase\Product\Images\Create\Command();
    }

    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('info.name')
            ->setBasePath('public/uploads/products')
            ->setUploadDir('/public/uploads/products')
            ->setUploadedFileNamePattern('[ulid].[extension]');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->createHandler->handle($command);
    }

    public function configureActions(Actions $actions): Actions
    {
        if (isset($_GET['entityId'])) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(ImageCrudController::class)
                ->setAction(Action::NEW)
                ->set('product_id', $_GET['product_id'])
                ->generateUrl();

            $actions->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) use ($url) {
                return $action->linkToUrl($url);
            });
        }

        return $actions->remove(Crud::PAGE_INDEX, Action::EDIT);
    }
}
