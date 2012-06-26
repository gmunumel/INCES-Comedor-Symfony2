<?php

namespace INCES\ComedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContabilidadType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('cedula', 'text')
            ->add('from', 'date', array(
                'widget'        => 'single_text',
                'format'        => 'dd/MM/yy',
                'required' => false,
            ))
            ->add('to', 'date', array(
                'widget'        => 'single_text',
                'format'        => 'dd/MM/yy',
                'required' => false,
            ))
            ->add('rol', 'entity', array(
                'class' => 'INCESComedorBundle:Rol',
                'empty_value' => 'Todos los Roles',
                'required' => false,
            ));
    }

    public function getName()
    {
        return 'inces_comedorbundle_contabilidadtype';
    }
}
