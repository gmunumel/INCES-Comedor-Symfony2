<?php

namespace INCES\ComedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('cedula', 'text',
                array('required' => false)
            )
            ->add('ncarnet')
            //->add('a_i')
            ->add('correo', 'text',
                array('required' => false)
            )
            ->add('image', 'file',
                array('required' => false)
            )
            ->add('rol')
        ;
    }

    public function getName()
    {
        return 'inces_comedorbundle_usuariotype';
    }
}
