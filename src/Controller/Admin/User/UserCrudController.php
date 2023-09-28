<?php

namespace App\Controller\Admin\User;

use App\Controller\Admin\Product\ImageCrudController;
use App\Controller\Admin\User\Cart\CartCrudController;
use App\Model\Cart\Entity\Cart\CartRepository;
use App\Model\User\Entity\User\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Message;

class UserCrudController extends AbstractCrudController
{
    protected $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        if (isset($_GET['entityId'])) {
            $cart = $this->cartRepository->findByUserId($_GET['entityId']);
            if ($cart) {
                $url = $this->container->get(AdminUrlGenerator::class)
                    ->setController(CartCrudController::class)
                    ->setAction(Action::EDIT)
                    ->setEntityId($cart->getId()->getValue())
                    ->set('user_id', $_GET['entityId'])
                    ->generateUrl();
            } else {
                $url = $this->container->get(AdminUrlGenerator::class)
                    ->setController(CartCrudController::class)
                    ->setAction('createCart')
                    ->set('user_id', $_GET['entityId'])
                    ->generateUrl();
            }

            $cartAction = Action::new('Cart', 'Cart', 'fa fa-file-invoice')
                ->linkToUrl($url);

            $actions->add(Crud::PAGE_EDIT, $cartAction);
        }

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
        ];
    }

//    public function configureActions(Actions $actions): Actions
//    {
//        $viewInvoice = Action::new('sendInvoice', 'Send Invoice', 'fa fa-file-invoice')
//            ->linkToCrudAction('sendInvoice');
//
//        return $actions->add(Crud::PAGE_INDEX, $viewInvoice);
//    }
//
//    public function sendInvoice(AdminContext $context, Request $request, MailerInterface $mailer)
//    {
//        $email = (new Email())
//            ->from('hello@example.com')
//            ->to('you@example.com')
//            //->cc('cc@example.com')
//            //->bcc('bcc@example.com')
//            //->replyTo('fabien@example.com')
//            //->priority(Email::PRIORITY_HIGH)
//            ->subject('Time for Symfony Mailer!')
//            ->text('Sending emails is fun again!')
//            ->html('<p>See Twig integration for better HTML integration!</p>');
//
//        $mailer->send($email);
//        //$order = $context->getEntity()->getInstance();
//
//        $route = $request->headers->get('referer');
//
//        return $this->redirect($route);
//    }
}
