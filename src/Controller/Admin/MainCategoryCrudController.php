<?php

namespace App\Controller\Admin;

use App\Entity\MainCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MainCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MainCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        
            ->setEntityLabelInSingular('une catégorie')
            ->setEntityLabelInPlural('Les catégories');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title')
                ->setLabel('Titre')
                ->setHelp('Titre de la catégorie'),

            /*AssociationField::new('products','Product')
            ->setLabel('Produit associé')
            ->setHelp(''), */
        ];
    }
    
}
