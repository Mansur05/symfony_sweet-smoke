<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $thumbnailFile = ImageField::new('thumbnailFile')->setFormType(VichImageType::class);
        $thumbnail = ImageField::new('thumbnail')->setBasePath('/src/posts')->hideOnForm();

        $fields = [
            TextField::new('title'),
            TextEditorField::new('summary')->hideOnIndex(),
            TextEditorField::new('content')->hideOnIndex(),
            DateTimeField::new('publishedAt')->hideOnForm(),
        ];

        if ($pageName === Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $thumbnail;
        } else {
            $fields[] = $thumbnailFile;
        }


        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, 'detail');
    }

}
