<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
        $currentYear = (new \DateTime())->format('Y');
        $years = [];
        for ($i = $currentYear - 1 ; $i <= $currentYear + 5 ; $i ++){
            $years[$i] = $i;
        }
        $builder
            ->add('company', null, ['label' => 'Компания', 'attr' => ['data-placeholder' => 'Выберите компанию'], 'required' => true])
            ->add('contractNumber', null, ['label' => '№ договора'])

//            ->add('magazine', null, ['label' => 'Издание', 'attr' => ['data-placeholder' => 'Выберите издание']])
//            ->add('idn', null, ['label' => 'Ид'])
            ->add('year', ChoiceType::class, ['label' => 'Год', 'choices' => $years, 'required' => true])

            ->add('goods', CollectionType::class, [
                'entry_type' => GoodType::class,
                'allow_add'    => true,
                'allow_delete'    => true,
                'auto_initialize' => true,
                'label' => ' '
            ])

//            ->add('price', null, ['label' => 'Стоимость (без НДС)'])
//            ->add('budget', null, ['label' => 'Бюджет'])
//            ->add('sale', null, ['label' => 'Скидка (в %)'])
            ->add('commission', null, ['label' => 'Агентская коммисия (в %)'])
//            ->add('interalBudget', null, ['label' => 'Внутренний бюджет'])
//            ->add('interalSale', null, ['label' => 'Внутренняя скидка (в %)'])
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
