<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;

class RegistrationType extends AbstractType {
    /**
     * @Assert\Type(type="AppBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('UserName', 'text');
        $builder->add('UserImage', 'text');
        $builder->add('plainPassword', 'repeated', array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => 'password',
        ));
        $builder->add('Register', 'submit');
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    public function getName() {
        return 'registration';
    }

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function getUser() {
        return $this->user;
    }

}