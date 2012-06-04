<?php

namespace INCES\ComedorBundle\Form\Type;

use INCES\ComedorBundle\Entity\UserAdmin;
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('nombre');
        $builder->add('apellido');
        $builder->add('cedula');
        $builder->add('ncarnet');
        //$builder->add('roles');
        //$user = new UserAdmin();
        //$builder->add('roles' ,'choice' ,array('choices'=>$user->getRoles()));
        $builder->add('roles', 'collection', array(
            'type'     => 'choice',
            'options'  => array(
                'choices'  => array(
                    'ROLE_ADMIN'    => 'Administrador',
                    'ROLE_GERENTE'  => 'Gerente',
                    'ROLE_OPERADOR' => 'Operador',
                    'ROLE_USUARIO'  => 'Usuario',
                ),
            ),
        ));
    }

    /*
    public function getNombre()
    {
        return 'inces_user_registration';
    }
    */
}
