<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoodType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Название'])
            ->add('month', ChoiceType::class, ['label' => 'Месяц', 'choices'  => array(
                'Январь' => 1,
                'Февраль' => 2,
                'Март' => 3,
                'Апрель' => 4,
                'Май' => 5,
                'Июнь' => 6,
                'Июль' => 7,
                'Август' => 8,
                'Сентябрь' => 9,
                'Октябрь' => 10,
                'Ноябрь' => 11,
                'Декабрь' => 12)
            ])
//            ->add('company', null, ['label' => 'Организация', 'attr'=> ['data-placeholder' => 'Выберите организацию']])
            ->add('price', null, ['label' => 'Прайс-лист', 'attr'=> ['data-placeholder' => 'Выберите позицию из прайс-иста']])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Good'
        ));
    }
}
