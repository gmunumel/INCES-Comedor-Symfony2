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
            ->add('salado')
            ->add('jugo')
            ->add('ensalada')
            ->add('postre')
            ->add('dia', 'date', array(
                'widget'        => 'single_text',
                'format'        => 'dd/MM/yy',
            ));
    }

    public function getName()
    {
        return 'inces_comedorbundle_menutype';
    }
}
