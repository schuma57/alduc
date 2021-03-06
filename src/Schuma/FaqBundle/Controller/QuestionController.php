<?php

namespace Schuma\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\FaqBundle\Entity\Question;
use Schuma\FaqBundle\Form\QuestionType;
use Schuma\FaqBundle\Entity\Answer;
use Schuma\FaqBundle\Form\AnswerType;
use Schuma\FaqBundle\Form\CategorySearchType;

class QuestionController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allAction(Request $request){
        $criteria = array();

        $categoryForm = $this->createForm(new CategorySearchType());

        if($categoryForm->handleRequest($request)->isValid()){
            if( !empty( $postedCategory = $categoryForm->getData()['category'] ) )
                $criteria['category'] = $postedCategory;
        }

        $questionList = $this->getDoctrine()
            ->getManager()
            ->getRepository('SchumaFaqBundle:Question')
            ->findBy($criteria, array('date'=>'DESC'));

        return $this->render('SchumaFaqBundle:Question:all.html.twig', array(
            'list' => $questionList,
            'categoryForm' => $categoryForm->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @param Question $question
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Question $question){
        $answer = new Answer();
        $answerForm = $this->createForm(new AnswerType(), $answer);

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        if($answerForm->handleRequest($request)->isValid()){
            $answer->setAuthor($this->getUser());
            $answer->setQuestion($question);
            $em->persist($answer);
            $em->flush($answer);

            return $this->redirect($this->generateUrl('schuma_faq_get_question', array(
                'id' => $question->getId())));
        }

        $answerList = $em->getRepository('SchumaFaqBundle:Answer')
                ->findBy(array('question' => $question), array('date' => 'DESC'));

        return $this->render('SchumaFaqBundle:Question:get.html.twig', array(
            'question' => $question,
            'answerForm' => $answerForm->createView(),
            'answerList' => $answerList,
            'answerNumber' => count($answerList),
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){
        $question = new Question();
        $form = $this->createForm(new QuestionType(), $question);

        if($form->handleRequest($request)->isValid()){
            $question->setAuthor($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_faq_all_question'));
        }

        return $this->render('SchumaFaqBundle:Question:add.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * Edits a question
     *
     * @param Question $question
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function editAction(Question $question){
        $this->get('schuma_user.security_service')
            ->userIsAuthorOrAdminOrThrowAccessDeniedException($question);

        $form = $this->createForm(new QuestionType(), $question);
        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_faq_get_question', array(
                'id' => $question->getId(),
            )));
        }

        return $this->render('SchumaFaqBundle:Question:add.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param Question $question
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws AccessDeniedException
     */
    public function deleteAction(Question $question){
        $this->get('schuma_user.security_service')
            ->userIsAuthorOrAdminOrThrowAccessDeniedException($question);

        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();

        return $this->redirect($this->generateUrl('schuma_faq_all_question'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayLastQuestionsAction(){
        $lastQuestions = $this->getDoctrine()->getManager()
            ->getRepository('SchumaFaqBundle:Question')
            ->getLast(10);

        return $this->render('SchumaFaqBundle::lastQuestions.html.twig', array(
            'lastQuestions' => $lastQuestions
        ));
    }
}
