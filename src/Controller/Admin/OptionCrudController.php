<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Option::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        
            ->setEntityLabelInSingular('une option')
            ->setEntityLabelInPlural('Les options');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            
            TextField::new('title')
                ->setLabel('titre'),

            TextEditorField::new('type')
                ->setLabel('prix additionnel'),

            NumberField::new('additional_price')
                ->setLabel('prix additionnel'),

            ArrayField::new('product', 'Product')
                ->setLabel('produits')
                ->setHelp(''),

            ArrayField::new('option_value', 'OptionValue')
                ->setLabel('valeur options')
                ->setHelp(''),
        ];
    }
}
