<?php

namespace App\Controller\Client;

use App\Entity\Customization;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;

class CustomizationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customization::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('product', 'Produit')->setDisabled(),
            ChoiceField::new('color', 'Couleur')->setChoices([
                'Noir' => 'black',
                'Blanc' => 'white',
                'Rouge' => 'red',
                'Bleu' => 'blue',
                'Vert' => 'green'
            ]),
            TextField::new('text', 'Texte personnalisé'),
            TextField::new('font', 'Police d’écriture'),
            ImageField::new('uploadedImage', 'Image')
                ->setUploadDir('public/uploads')
                ->setBasePath('/uploads'),
            BooleanField::new('isValidated', 'Validé')->setDisabled(),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (!$this->isGranted('ROLE_ADMIN')) {
            $qb->andWhere('entity.user = :user')->setParameter('user', $this->getUser());
        }

        return $qb;
    }
}
