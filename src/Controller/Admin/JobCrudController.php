<?php

namespace App\Controller\Admin;

use App\Entity\Job;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class JobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Job::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('description', 'Description'),
            TextField::new('country', 'Pays'),
            TextField::new('city', 'Ville'),
            BooleanField::new('remoteAllowed', 'Télétravail possible'),
            TextField::new('salaryRange', 'Fourchette salariale'),
            AssociationField::new('company', 'Entreprise')->setRequired(true),
            AssociationField::new('type', 'Type de contrat')->setRequired(true),
            AssociationField::new('categories', 'Catégories')->setRequired(true),
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
        ];
    }
}
