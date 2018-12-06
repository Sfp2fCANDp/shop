<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $category = new CategoryRepository();
//        dd($category->findAll());
        $builder
            ->add('price')
            ->add('name')
            ->add('description')
            /*->add('category', CollectionType::class, array(
                'entry_type'    => CategoryType::class,
                'allow_add' => true,
            ))*/
            ->add('category', EntityType::class, array(
                'class'  => Category::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository -> createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
            ))
//            ->add('images', CollectionType::class, array(
//                'entry_type' => ImageType::class
//            ))
            ->add('images', FileType::class, [
                'mapped' => false,
                'label' => 'Upload images'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
