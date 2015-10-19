<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChatRoomController
 *
 * @author sousa
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\ChatRoom;
use AppBundle\Form\ChatRoomType;

class ChatRoomController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $chatrooms = $em->getRepository('AppBundle:ChatRoom')->findAll();
        return $this->render('AppBundle:ChatRoom:index.html.twig', array(
                    'chatrooms' => $chatrooms
        ));
    }

    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $chatroom = $em->getRepository('AppBundle:ChatRoom')->find($id);

        $delete_form = $this->createFormBuilder()
                ->setAction($this->generateUrl('chatroom_delete', array('id' => $id)))
                ->setMethod('DELETE')
                ->add('submit', 'submit', array('label' => 'Delete Chat Room'))
                ->getForm();
        return $this->render('AppBundle:ChatRoom:show.html.twig', array(
                    'chatroom' => $chatroom,
                    'delete_form' => $delete_form->createView()
        ));
    }

    public function msgAction(Request $request) {
        $params = array();
        $content = $this->get("request")->getContent();
        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
        }
        $em = $this->getDoctrine()->getManager();
        $chatroom = $em->getRepository('AppBundle:ChatRoom')->findOneBy(array('name' => $params['chatroom']));
        $chatroom->setText($chatroom->getText() . $params['msg']);
        $em->flush();

        /** Ver anotations para fazer cascade (gravar em cascata os objetos) **/
        /* FIRST COMMIT SAVED FROM HOME :) */
        /*********************************************************/
        $em = $this->getDoctrine()->getManager();
        $chatroom = $em->getRepository('AppBundle:ChatRoom')->findOneBy(array('name' => $params['chatroom']));

        $message = new \AppBundle\Entity\Message();
        $message->setCreatedAt();
        $message->setCreatedBy($params['user']);
        $message->setText($params['msg']);

        $chatroom->getMessages()->add($message);

        $em->persist($chatroom);
        $em->flush();
        /*********************************************************/

        $response = new Response(json_encode(array('OK' => '')));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function newAction(Request $request) {
//
//        $chatroom = new ChatRoomType();
//        $form = $this->createForm(new ChatRoomType(), $chatroom, array(
//            'action' => $this->generateUrl('chatroom_create'),
//        ));
//
//        return $this->render('AppBundle:ChatRoom:new.html.twig',
//                array('form' => $form->createView())
//        );

        return $this->render('AppBundle:ChatRoom:new.html.twig');
    }

//        public function createAction(Request $request) {
//        }
//
}
