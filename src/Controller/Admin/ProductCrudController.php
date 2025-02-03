<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\DBAL\Types\ArrayType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        
            ->setEntityLabelInSingular('un produit')
            ->setEntityLabelInPlural('Les produits');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            // Champ pour le titre du produit
            TextField::new('title')
                ->setLabel('Titre')
                ->setHelp('Titre du produit'),
            
            // Champ pour le type du produit
            TextField::new('type')
                ->setLabel('Type')
                ->setHelp('Type du produit (ex : électronique, vêtement)'),

            // Champ pour le nom du type du produit
            TextField::new('type_name')
                ->setLabel('Nom du Type')
                ->setHelp('Nom spécifique du type de produit'),

            // Champ pour la marque du produit
            TextField::new('brand')
                ->setLabel('Marque')
                ->setHelp('Marque du produit'),

            // Champ pour le modèle du produit
            TextField::new('model')
                ->setLabel('Modèle')
                ->setHelp('Modèle du produit'),

            // Champ pour la description du produit
            TextEditorField::new('description')
                ->setLabel('Description')
                ->setHelp('Description détaillée du produit'),

            // Champ pour l'image du produit
            ImageField::new('image')
                ->setLabel('Image')
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setBasePath('/uploads/images')
                ->setUploadDir('public/uploads/images')
                ->setHelp('Image du produit. Le fichier sera automatiquement renommé.'), 

            // Champ pour le nombre de variantes du produit
            NumberField::new('variant_count')
                ->setLabel('Nombre de Variantes')
                ->setHelp('Nombre de variantes disponibles pour ce produit'),

            // Champ pour la monnaie utilisée
            TextField::new('currency')
                ->setLabel('Devise')
                ->setHelp('Devise utilisée pour le prix du produit (ex : EUR, USD)'),

            // Champ pour les dimensions du produit
            TextField::new('dimensions')
                ->setLabel('Dimensions')
                ->setHelp('Dimensions du produit (ex : 20x10x5 cm)')
                ->onlyOnForms(),  // Seulement affiché lors de la création/édition du produit

            // Champ pour le statut de fin de commercialisation du produit
            BooleanField::new('is_discontinued')
                ->setLabel('Fin de Commercialisation')
                ->setHelp('Indique si le produit est arrêté')
                ->hideValueWhenFalse(),

            // Champ pour le temps moyen de traitement des commandes
            NumberField::new('avg_fulfillment_time')
                ->setLabel('Temps moyen de traitement')
                ->setHelp('Temps moyen en jours pour traiter une commande de ce produit'),

            // Champ pour le pays d'origine du produit
            TextField::new('origin_country')
                ->setLabel('Pays d\'Origine')
                ->setHelp('Pays d\'origine du produit'),

            // Champ pour l'ID Printfull
            NumberField::new('idPrintfull')
                ->setLabel('ID Printfull')
                ->setHelp('Identifiant du produit dans Printfull'),

            // Association avec la catégorie principale
            AssociationField::new('main_category')
                ->setLabel('Catégorie principale')
                ->setHelp('Catégorie principale du produit')
                ->setCrudController(MainCategoryCrudController::class),
            
            CollectionField::new('options')
                ->setLabel('Options')
                ->setHelp('Options du produit (ex : couleurs, tailles)')
                ->allowAdd()  // Permet l'ajout de nouvelles options
                ->allowDelete(),  // Permet de supprimer des options
            
            AssociationField::new('techniques')
                ->setLabel('Techniques')
                ->setHelp('Techniques de fabrication disponibles pour ce produit')
                ->setCrudController(TechniqueCrudController::class),
            
            AssociationField::new('files')
                ->setLabel('Fichiers')
                ->setHelp('Liste des fichiers associés au produit (ex : mockup, images)') 
                ->setCrudController(FileCrudController::class),             
        ];
    } 
}