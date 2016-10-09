<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\FormatToStringTransformer;
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
            ->add('house', null, ['label' => 'Издательство'])
            ->add('format', TextType::class, ['label' => 'Формат', 'attr' => ['class' => 'format']])
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

        $builder->get('format')->addModelTransformer(new FormatToStringTransformer($this->manager));
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
