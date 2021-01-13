<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\PictureType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('content'),
            TextField::new('price'),
            IntegerField::new('quantity'),
            BooleanField::new('isPromo'),
            CollectionField::new('picture')
            ->setEntryType(PictureType::class),
            AssociationField::new('category'),
            AssociationField::new('size'),
            TextField::new('slug'),
        ];
    }
}
