<?php

namespace Schuma\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\BlogBundle\Entity\Comment;
use Schuma\BlogBundle\Form\CommentType;


class CommentController extends Controller{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allAction(){
        $listEvents = $this->getDoctrine()->getManager()
                ->getRepository('SchumaBlogBundle:Comment')
                ->findBy(array(), array('date'=>'DESC'));

        return $this->render('SchumaBlogBundle:Comment:all.html.twig', array(
            'list' => $listEvents,
        ));
    }

    /**
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Comment $comment){
        return $this->render('SchumaBlogBundle:Comment:get.html.twig', array(
            'comment' => $comment
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Comment $comment){
        $form = $this->createForm(new CommentType(), $comment);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_blog_all_comment'));
        }

        return $this->render('SchumaBlogBundle:Comment:add.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Comment $comment){
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($comment);
        $manager->flush();

        return $this->redirect($this->get('request')->headers->get('referer'));
    }
}
