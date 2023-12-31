<?php

namespace App\Controller\Admin\Product;

use App\Controller\Admin\AbstractCrudController;
use App\Model\Product\UseCase as UseCase;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Model\Product\Entity\Product\Product;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ProductCrudController extends AbstractCrudController
{
    public $createHandler;
    public $editHandler;

    public function __construct(
        UseCase\Product\Create\Handler $createHandler,
        UseCase\Product\Edit\Handler $editHandler
    )
    {
        $this->createHandler = $createHandler;
        $this->editHandler = $editHandler;
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function getNewCommand()
    {
        return new UseCase\Product\Create\Command();
    }

    public function getEditCommand($id)
    {
        return new UseCase\Product\Edit\Command($id);
    }

//    public function getRemoveCommand($id)
//    {
//        return new UseCase\Category\Remove\Command($id);
//    }

    public function persistEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->createHandler->handle($command);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->editHandler->handle($command);
    }

//    public function deleteEntity(EntityManagerInterface $entityManager, $command): void
//    {
//        $this->removeHandler->handle($command);
//    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                IdField::new('id'),
                TextField::new('info.name')
            ];
        } elseif(Crud::PAGE_NEW === $pageName) {
            return [
                TextField::new('info.name'),
                TextareaField::new('info.description')->setMaxLength(1000),
                TextareaField::new('info.specification')->setMaxLength(1000),
                NumberField::new('price.old')->setNumDecimals(2),
                NumberField::new('price.new')->setNumDecimals(2),
                TextField::new('slug'),
                AssociationField::new('category')->autocomplete(),
                AssociationField::new('brand')->autocomplete()->setRequired(false),
                AssociationField::new('tag')->autocomplete()->setRequired(false)
            ];
        } else {
            return [
                TextField::new('info.name'),
                TextareaField::new('info.description')->setMaxLength(1000),
                TextareaField::new('info.specification')->setMaxLength(1000),
                NumberField::new('price.old')->setNumDecimals(2),
                NumberField::new('price.new')->setNumDecimals(2),
                TextField::new('slug'),
                AssociationField::new('category')->autocomplete(),
                AssociationField::new('brand')->autocomplete()->setRequired(false),
                AssociationField::new('tag')->autocomplete()->setRequired(false),
                AssociationField::new('featuresValues')->autocomplete()->setRequired(false)
            ];
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        if (isset($_GET['entityId'])) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(ImageCrudController::class)
                ->setAction(Action::INDEX)
                ->set('product_id', $_GET['entityId'])
                ->generateUrl();

            $viewInvoice = Action::new('Images', 'Images', 'fa fa-file-invoice')
                ->linkToUrl($url);

            $actions->add(Crud::PAGE_EDIT, $viewInvoice);
        }

        return $actions;
    }
}
