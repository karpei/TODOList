<?php
namespace star\TODOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use star\TODOBundle\Entity\Users;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username',TextType::class,array('label'=>'Логин'))
                ->add('email',EmailType::class)
                ->add('password',RepeatedType::class,['type'=>PasswordType::class,
                    'first_options'  => array('label' => 'Пароль'),
                    'second_options' => array('label' => 'Повторите пароль'),
                ])
                ->add('submit',SubmitType::class,array('attr' => array('class' => 'btn btn-success pull-right'),'label'=>'Зарегестрироваться'));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Users::class
        ));
    }
}