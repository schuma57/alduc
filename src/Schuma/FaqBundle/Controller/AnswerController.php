<?php

namespace Schuma\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\FaqBundle\Entity\Answer;
use Schuma\FaqBundle\Form\AnswerType;

class AnswerController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function allAction(){
        $answerList = $this->getDoctrine()
            ->getManager()
            ->getRepository('SchumaFaqBundle:Answer')
            ->findBy(array(), array('date'=>'DESC'));

        return $this->render('SchumaFaqBundle:Answer:all.html.twig', array(
            'list' => $answerList,
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @param Answer $answer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Answer $answer){
        return $this->render('SchumaFaqBundle:Answer:get.html.twig', array(
            'answer' => $answer
        ));
    }

    /**
     * @param Answer $answer
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function editAction(Answer $answer){
        $this->get('schuma_user.security_service')
            ->userIsAuthorOrAdminOrThrowAccessDeniedException($answer);

        $form = $this->createForm(new AnswerType(), $answer);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_faq_get_question', array(
                'id' => $answer->getQuestion()->getId(),
            )));
        }

        return $this->render('SchumaFaqBundle:Answer:edit.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param Answer $answer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Answer $answer){
        try{
            $this->get('schuma_user.security_service')
                ->userIsAuthorOrAdminOrThrowAccessDeniedException($answer);

            $em = $this->getDoctrine()->getManager();
            $em->remove($answer);
            $em->flush();
        }
        catch (AccessDeniedException $ex){

        }

        return $this->redirect($this->get('request')->headers->get('referer'));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayLastAnswersAction(){
        $lastAnswers = $this->getDoctrine()->getManager()
            ->getRepository('SchumaFaqBundle:Answer')
            ->getLast(10);

        return $this->render('SchumaFaqBundle::lastAnswers.html.twig', array(
            'lastAnswers' => $lastAnswers
        ));
    }
}
