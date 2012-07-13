<?php

namespace INCES\ComedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserAdminType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username', 'text',
                array('required' => false)
            )
            ->add('nombre', 'text',
                array('required' => false)
            )
            ->add('apellido', 'text',
                array('required' => false)
            )
            ->add('cedula', 'text',
                array('required' => false)
            )
            ->add('ncarnet', 'text',
                array('required' => false)
            )
            //->add('a_i')
            ->add('email', 'text',
                array('required' => false)
            )
            ->add('roles', 'collection', array(
                'type'     => 'choice',
                'options'  => array(
                    'choices'=> array(
                        'ROLE_ADMIN'    => 'Administrador',
                        'ROLE_GERENTE'  => 'Gerente',
                        'ROLE_OPERADOR' => 'Operador',
                        'ROLE_USUARIO'  => 'Usuario',
                    ),
                ),
            ))
        ;
    }

    public function getName()
    {
        return 'inces_comedorbundle_useradmintype';
    }
}
