<?php

namespace App\Controller\Admin\User\Cart;

use App\Controller\Admin\AbstractCrudController;
use App\Controller\Admin\User\UserCrudController;
use App\Model\Cart\Entity\CartItem\CartItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class CartItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CartItem::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $url = $this->container->get(AdminUrlGenerator::class)
            ->setController(CartCrudController::class)
            ->setAction(Action::EDIT)
            ->setEntityId($_GET['cart_id'])
            ->set('user_id', $_GET['user_id'])
            ->generateUrl();

        $toCart = Action::new('ToCart', 'To cart', 'fa fa-file-invoice')
            ->linkToUrl($url)->createAsGlobalAction();

        $actions->add(Crud::PAGE_INDEX, $toCart);

        return $actions;
    }
}
