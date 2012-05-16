<?php

namespace INCES\ComedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('seco')
            ->add('sopa')
            ->add('dia')
        ;
    }

    public function getName()
    {
        return 'inces_comedorbundle_menutype';
    }
}
