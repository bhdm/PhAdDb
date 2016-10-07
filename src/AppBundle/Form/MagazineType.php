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
            ->add('house', null, ['label' => 'Издательство'])
            ->add('format', null, ['label' => 'Формат'])
            ->add('title', null, ['label' => 'Название'])
            ->add('circulation', null, ['label' => 'Тираж'])
            ->add('periodicity', null, ['label' => 'Периодичность'])
            ->add('nosologies', null, ['label' => 'Нозологии'])
            ->add('bak', null, ['label' => 'BAK'])
            ->add('impactFactor', null, ['label' => 'Импакт-фактор издания'])
            ->add('citationSystem', null, ['label' => 'Международные системы цитирования'])
            ->add('mainEditor', null, ['label' => 'ФИО, регалии Главного редактора'])
            ->add('audience', null, ['label' => 'Аудитория издания'])
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
