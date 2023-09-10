<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Coupon\Entity\Sale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CouponForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('code')
            ->add('sale', CouponSaleForm::class);
    }
}
