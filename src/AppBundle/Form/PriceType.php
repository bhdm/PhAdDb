<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('magazine', null, ['label' => 'Журнал'])
            ->add('year', null, ['label' => 'Год'])
            ->add('price', null, ['label' => 'Стоимость без НДС'])
            ->add('nds', CheckboxType::class, ['label' => 'Работает с НДС', 'required' => false])
            ->add('format', null, ['label' => 'Формат'])
            ->add('position', null, ['label' => 'Позиция, рекламный формат'])
            ->add('color', ChoiceType::class, ['label' => 'цветность', 'choices' => ['4C' => true, 'B&W' => false]])
            ->add('publicationBonus', null, ['label' => 'Статья бонусом (формат)', 'required' => false])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Price'
        ));
    }
}
