<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MagazineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Название'])
            ->add('circulation', null, ['label' => 'Тираж'])
            ->add('periodicity', null, ['label' => 'Периодичность'])
            ->add('bak', null, ['label' => 'BAK'])
            ->add('nosologies', null, ['label' => 'Нозологии'])
            ->add('house', null, ['label' => 'Издательство'])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Magazine'
        ));
    }
}
