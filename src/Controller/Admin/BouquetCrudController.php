<?php

namespace App\Controller\Admin;

use App\Entity\Bouquet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BouquetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bouquet::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Просмотр');
            })
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Добавить');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        yield CollectionField::new('flowerItems', "Цветы")->useEntryCrudForm();
        yield AssociationField::new('package', "Упаковка");
        yield AssociationField::new('decoration', "Украшение");
    }
}
