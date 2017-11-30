<?php

namespace star\TODOBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class EditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',null,array('label'=>'Задача', 'attr' => array('class' => 'form-control')))->
        add('description',null,array('label'=>'Описание задачи', 'attr' => array('class' => 'form-control')))->add('status',ChoiceType::class, array(
            'label'=>'Статус','choices' => array('Не выполнено' => 0, 'Выполнено' => 1)));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'star\TODOBundle\Entity\Tasks'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'star_todobundle_tasks';
    }
}