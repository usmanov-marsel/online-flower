<?php

namespace App\Controller\Admin;

use App\Entity\Package;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PackageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Package::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Упаковки')
            ->setEntityLabelInPlural('Упаковки')
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Обновить');
            })
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Добавить');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setLabel('Удалить');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setLabel('Добавить в магазин');
            })
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Название');
        yield TextareaField::new('description', 'Описание')->hideOnIndex();
        //yield IntegerField::new('price', 'Цена')->setNumberFormat('%.2f')->formatValue(fn ($value) => $value / 100);
        yield MoneyField::new('price', 'Цена')->setCurrency("RUB");
        yield ImageField::new('img', 'Фотография')
            ->setUploadDir('public/uploads/images')
            ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
            ->setBasePath('/uploads/images');
    }
}
