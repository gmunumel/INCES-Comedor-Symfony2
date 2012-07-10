<?php

namespace INCES\ComedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class UsuarioExternoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('cedula')
            ->add('ncarnet')
            //->add('a_i')
            ->add('correo')
            ->add('image', 'file',
                array('required' => false)
            )
            ->add('rol', 'entity', array(
                'class' => 'INCESComedorBundle:Rol',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where("r.nombre = 'Externo'");
                },
            ))
        ;
    }

    public function getName()
    {
        return 'inces_comedorbundle_usuarioexternotype';
    }
}
