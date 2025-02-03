<?php

namespace App\Controller\Admin;

use App\Entity\OptionValue;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OptionValueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OptionValue::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        
            ->setEntityLabelInSingular("une valeur d'option")
            ->setEntityLabelInPlural("Les valeurs d'options");
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            TextEditorField::new('value')
                ->setLabel('valeur')
                ->setHelp(''),

            NumberField::new('additional_price')
                ->setLabel('prix additionel')
                ->setHelp(''),

            ArrayField::new('optiona')
                ->setLabel('option')
                ->setHelp(''),
        ];
    }
}
