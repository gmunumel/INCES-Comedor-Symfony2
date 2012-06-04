<?php

namespace INCES\ComedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RolType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('monto')
            ->add('horaComerStart')
            ->add('horaComerEnd')
        ;
    }

    public function getName()
    {
        return 'inces_comedorbundle_roltype';
    }
}
