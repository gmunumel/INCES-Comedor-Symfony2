<?php

namespace INCES\ComedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CargaMasivaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('file', 'file',
                array('required' => false)
            )
        ;
    }

    public function getName()
    {
        return 'inces_comedorbundle_carga_masivatype';
    }
}
