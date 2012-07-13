<?php

namespace INCES\ComedorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProfileFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $child = $builder->create('user', 'form', array('data_class' => $this->class));
        $this->buildUserForm($child, $options);

        $builder
            ->add($child)
            ->add('current', 'password')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            //'data_class' => 'FOS\UserBundle\Form\Model\CheckPassword',
            'data_class' => 'INCES\ComedorBundle\Entity\UserAdmin',
            'intention'  => 'profile',
        );
    }

    public function getName()
    {
        return 'fos_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilder $builder
     * @param array       $options
     */
    protected function buildUserForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'email')
            ->add('nombre', 'text'
               // array('required' => false)
            )
            ->add('plainPassword', 'password',
                array('required' => false, 'type' => 'password')
            )
            ->add('plainPassword', 'repeated',
                array('required' => false, 'type' => 'password')
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
        ;
    }
}
