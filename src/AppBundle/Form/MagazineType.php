<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\FormatToStringTransformer;
use AppBundle\Form\DataTransformer\SpreadToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MagazineType extends AbstractType
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
        $builder
            ->add('idn', null, ['label' => 'ИД', 'attr'=> ['required' => 'true']])
            ->add('house', null, ['label' => 'Издательство', 'attr'=> ['data-placeholder' => 'Выберите издательский дом']])
            ->add('format', TextType::class, ['label' => 'Формат', 'attr' => ['class' => 'format']])
            ->add('title', null, ['label' => 'Название'])
            ->add('circulation', null, ['label' => 'Тираж'])
            ->add('periodicity', null, ['label' => 'Периодичность'])
            ->add('nosologies', null, ['label' => 'Нозологии', 'attr'=> ['data-placeholder' => 'Выберите из списка']])
            ->add('bak', null, ['label' => 'BAK'])
            ->add('impactFactor', null, ['label' => 'Импакт-фактор издания'])
            ->add('citationSystem', null, ['label' => 'Международные системы цитирования'])
            ->add('mainEditor', null, ['label' => 'ФИО, регалии Главного редактора'])
//            ->add('spread', TextType::class , ['label' => 'Распространение', 'attr' => ['class' => 'spread multiple']])
            ->add('audience', null, ['label' => 'Аудитория издания'])

        ;

        $builder->get('format')->addModelTransformer(new FormatToStringTransformer($this->manager));
//        $builder->get('spread')->addModelTransformer(new SpreadToStringTransformer($this->manager));
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
