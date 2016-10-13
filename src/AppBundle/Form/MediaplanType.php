<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaplanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', null, ['label' => 'Компания', 'attr' => ['data-placeholder' => 'Выберите компанию']])
            ->add('contractNumber', null, ['label' => '№ договора'])
            ->add('magazine', null, ['label' => 'Издание', 'attr' => ['data-placeholder' => 'Выберите издание']])
            ->add('idn', null, ['label' => 'Ид'])
            ->add('year', null, ['label' => 'Год'])
//            ->add('months', null, ['label' => 'Год'])
            ->add('price', null, ['label' => 'Стоимость (без НДС)'])
            ->add('budget', null, ['label' => 'Бюджет'])
            ->add('sale', null, ['label' => 'Скидка (в %)'])
            ->add('commission', null, ['label' => 'Агентская коммисия (в %)'])
            ->add('interalBudget', null, ['label' => 'Внутренний бюджет'])
            ->add('interalSale', null, ['label' => 'Внутренняя скидка (в %)'])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Mediaplan'
        ));
    }
}
