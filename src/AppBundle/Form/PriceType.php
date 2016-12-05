<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\FormatToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

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
            ->add('magazine', null, ['label' => 'Журнал', 'required' => true])
            ->add('year', ChoiceType::class, ['label' => 'Год', 'choices' => $years])
            ->add('price', null, ['label' => 'Стоимость без НДС'])
            ->add('nds', CheckboxType::class, ['label' => 'Работает с НДС', 'required' => false])
            ->add('format', TextType::class, ['label' => 'Формат', 'attr' => ['class' => 'format']])
            ->add('position', null, ['label' => 'Позиция, рекламный формат'])
            ->add('color', ChoiceType::class, ['label' => 'цветность', 'choices' => ['4C' => true, 'B&W' => false]])
            ->add('publicationBonus', TextType::class, ['label' => 'Статья бонусом (формат)', 'required' => false, 'attr' => ['class' => 'format']])
        ;

        $builder->get('format')->addModelTransformer(new FormatToStringTransformer($this->manager));
        $builder->get('publicationBonus')->addModelTransformer(new FormatToStringTransformer($this->manager));

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
