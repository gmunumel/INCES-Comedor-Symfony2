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
            ->add('horaComerStart', 'choice', array(
                'choices' => array(
                    '00' => '00',
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12'
                )
            ))
            ->add('horaComerStartAMPM', 'choice', array(
                'choices' => array(
                    'am' => 'am',
                    'pm' => 'pm'
                )
            ))
            ->add('horaComerEnd', 'choice', array(
                'choices' => array(
                    '00' => '00',
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12'
                )
            ))
            ->add('horaComerEndAMPM', 'choice', array(
                'choices' => array(
                    'am' => 'am',
                    'pm' => 'pm'
                )
            ))
        ;
    }

    public function getName()
    {
        return 'inces_comedorbundle_roltype';
    }
}
