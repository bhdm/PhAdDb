<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Название компании'])
            ->add('requisites', null, ['label' => 'Реквизиты'])
            ->add('contactPerson', null, ['label' => 'ФИО'])
            ->add('contactPost', null, ['label' => 'Должность'])
            ->add('contactEmail', null, ['label' => 'E-mail'])
            ->add('contactPhone', null, ['label' => 'Телефон'])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Company'
        ));
    }
}
