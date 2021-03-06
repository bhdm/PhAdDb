<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', null, ['label' => 'E-mail']);
        $builder->add('username', HiddenType::class, ['required' => false]);
        $builder->add('lastName', null, ['label' => 'Фамилия']);
        $builder->add('firstName', null, ['label' => 'Имя']);
        $builder->add('surName', null, ['label' => 'Отчество']);
        $builder->add('post', null, ['label' => 'Должность']);
//        $builder->add('roles', ChoiceType::class, [
//            'label' => 'Права',
//            'choices' => ['Администратор' => 'ROLE_ADMIN','Пользователь' => 'ROLE_USER']
//        ]);

        $builder->add('plainPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'Пароли должны совпадать',
            'options' => array('attr' => array('class' => 'password-field')),
            'required' => true,
            'first_options'  => array('label' => 'Пароль'),
            'second_options' => array('label' => 'Повторите пароль'),
        ));

//        $builder->add('admin', CheckboxType::class, ['label' => 'Администратор', 'mapped' => false, 'required' => false]);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}