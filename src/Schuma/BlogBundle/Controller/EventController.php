<?php

namespace Schuma\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\BlogBundle\Entity\Event;
use Schuma\BlogBundle\Form\EventType;
use Schuma\BlogBundle\Form\EventEditType;


class EventController extends Controller{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allAction(){
        $listEvents = $this->getDoctrine()->getManager()
                ->getRepository('SchumaBlogBundle:Event')
                ->findBy(array(), array('date'=>'DESC'));

        return $this->render('SchumaBlogBundle:Event:all.html.twig', array(
            'list' => $listEvents,
        ));
    }

    /**
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Event $event){
        return $this->render('SchumaBlogBundle:Event:get.html.twig', array(
            'event' => $event
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(){
        $event = new Event();
        $form = $this->createForm(new EventType(), $event);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $this->sendEmail();

            return $this->redirect($this->generateUrl('schuma_blog_all_event'));
        }

        return $this->render('SchumaBlogBundle:Event:add.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Event $event){
        $form = $this->createForm(new EventEditType(), $event);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_blog_all_event'));
        }

        return $this->render('SchumaBlogBundle:Event:add.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Event $event){
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($event);
        $manager->flush();

        return $this->redirect($this->generateUrl('schuma_blog_all_event'));
    }

    /**
     * Sends a mail
     */
    private function sendEmail(){
        $tab = array();
        $mailingList = $this->getDoctrine()
            ->getManager()
            ->getRepository('SchumaUserBundle:User')
            ->getMailingList();

        foreach($mailingList as $line)
            $tab[] = $line['email'];

        $this->get('mailer')->send($this->prepareEmail($tab));
    }

    /**
     * @param array $list
     * @return \Swift_Mime_MimePart
     */
    private function prepareEmail($list){
        $message = \Swift_Message::newInstance()
            ->setSubject("[ALDUC] Un nouvel évènement vient d'être ajouté")
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($list)
            ->setBody('Retrouvez tous les évènements, sur notre site. \n http://alduc.fr/evenements/')
        ;

        return $message;
    }
}
