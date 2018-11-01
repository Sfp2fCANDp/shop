<?php
    /**
     * Created by PhpStorm.
     * User: torop
     * Date: 01-Nov-18
     * Time: 8:01 PM
     */

    namespace App\Form;

    use App\Entity\Product;
    use phpDocumentor\Reflection\Types\Float_;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\NumberType;
    use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ProductType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('price', NumberType::class)
                ->add('name', TextType::class)
                ->add('description', TextType::class)
            ;
        }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                'data_class' => Product::class,
            ));
        }
    }