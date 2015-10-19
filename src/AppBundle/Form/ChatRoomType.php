<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChatRoomType
 *
 * @author sousa
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChatRoom extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('chat_room_name')->add('chat_pool')->add('user_input')->add('users_logged');
    }

    public function seDefaultOptions() {
        $resolver->setDefaults(array('data_class'=>'AppBundle\Entity\ChatRoom'));
    }

    public function getName() {
        return 'chatroom_managerbundle';
    }
}