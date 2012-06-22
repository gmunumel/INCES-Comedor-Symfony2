<?php

namespace INCES\ComedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UsuarioMenuType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('dia')
            ->add('usuario')
            ->add('menu')
        ;
    }

    public function getName()
    {
        return 'inces_comedorbundle_usuariomenutype';
    }
}
