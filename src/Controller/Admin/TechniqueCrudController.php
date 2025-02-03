<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Technique;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechniqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Technique::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        
            ->setEntityLabelInSingular("technique")
            ->setEntityLabelInPlural("Les techniques");
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            TextField::new('cle')
            ->setLabel('valeur')
            ->setHelp(''),

            TextField::new('display_name')
                ->setLabel("nom d'affichage")
                ->setHelp(''),

            BooleanField::new('is_default')
                ->setLabel('')
                ->setHelp('vrai ou faux')
                ->hideValueWhenTrue(),

            /*ArrayField::new('product','Product')
                ->setLabel('')
                ->setHelp(''),*/
        ];
    }
}
