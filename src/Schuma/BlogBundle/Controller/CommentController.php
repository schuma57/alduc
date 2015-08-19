<?php

namespace Schuma\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function editAction(Comment $comment){
        $this->get('schuma_user.security_service')
            ->userIsAuthorOrAdminOrThrowAccessDeniedException($comment);

        $form = $this->createForm(new CommentType(), $comment);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_blog_get_article', array(
                'id' => $comment->getArticle()->getId(),
            )));
        }

        return $this->render('SchumaBlogBundle:Comment:edit.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws AccessDeniedException
     */
    public function deleteAction(Comment $comment){
        $this->get('schuma_user.security_service')
            ->userIsAuthorOrAdminOrThrowAccessDeniedException($comment);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($comment);
        $manager->flush();

        return $this->redirect($this->get('request')->headers->get('referer'));
    }
}
