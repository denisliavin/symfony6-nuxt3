<?php

namespace App\Controller\Admin\User\Cart;

use App\Controller\Admin\AbstractCrudController;
use App\Controller\Admin\Product\ProductCrudController;
use App\Controller\Admin\User\UserCrudController;
use App\Model\Cart\UseCase;
use App\Model\Cart\Entity\Cart\Id;
use App\Model\Cart\Entity\Cart\Cart;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class CartCrudController extends AbstractCrudController
{
    public $createHandler;
    public $editHandler;

    public function __construct(
        UseCase\Cart\Create\Handler $createHandler,
        UseCase\Cart\Edit\Handler $editHandler
    )
    {
        $this->createHandler = $createHandler;
        $this->editHandler = $editHandler;
    }

    public static function getEntityFqcn(): string
    {
        return Cart::class;
    }

    public function createCart(UseCase\Cart\Create\Command $command)
    {
        $command->user_id = $_GET['user_id'];
        $command->cart_id = Id::next();
        $this->createHandler->handle($command);

        $url = $this->container->get(AdminUrlGenerator::class)
            ->setController(CartCrudController::class)
            ->setAction(Action::EDIT)
            ->setEntityId($command->cart_id->getValue())
            ->set('user_id', $command->user_id)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function getEditCommand($id)
    {
        return new UseCase\Cart\Edit\Command($id);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $command): void
    {
        $this->editHandler->handle($command);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('coupon')->autocomplete()
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $url = $this->container->get(AdminUrlGenerator::class)
            ->setController(UserCrudController::class)
            ->setAction(Action::EDIT)
            ->setEntityId($_GET['user_id'])
            ->generateUrl();

        $toUser = Action::new('ToUser', 'To user', 'fa fa-file-invoice')
            ->linkToUrl($url);

        $actions->add(Crud::PAGE_EDIT, $toUser);

        if (isset($_GET['entityId']) && $_GET['entityId']) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setController(CartItemCrudController::class)
                ->setAction(Action::INDEX)
                ->set('cart_id', $_GET['entityId'])
                ->set('user_id', $_GET['user_id'])
                ->generateUrl();

            $toCartItems = Action::new('ToCartItems', 'To cart items', 'fa fa-file-invoice')
                ->linkToUrl($url);

            $actions->add(Crud::PAGE_EDIT, $toCartItems);
        }

        $actions->remove(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN);

        return $actions;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
