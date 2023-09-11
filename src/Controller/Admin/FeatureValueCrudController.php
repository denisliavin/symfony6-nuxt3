<?php

namespace App\Controller\Admin;

use App\Model\Feature\Entity\Feature\FeatureValue;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FeatureValueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FeatureValue::class;
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
