<?php

namespace Schuma\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\BlogBundle\Entity\Article;
use Schuma\BlogBundle\Form\ArticleType;
use Schuma\BlogBundle\Form\ArticleEditType;
use Schuma\BlogBundle\Entity\Comment;
use Schuma\BlogBundle\Form\CommentType;


class ArticleController extends Controller{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allAction(){
        $listArticles = $this->getDoctrine()->getManager()
                            ->getRepository('SchumaBlogBundle:Article')
                            ->findBy(array(), array('date'=>'DESC'));

        return $this->render
            ('SchumaBlogBundle:Article:all.html.twig',
                array('list' => $listArticles ));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(){
        $article = new Article();
        $form = $this->createForm(new ArticleType, $article);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $article->setAuthor($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_blog_articles'));
        }

        return $this->render
            ('SchumaBlogBundle:Article:add.html.twig',
                array('form'=> $form->createView() ));
    }


    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function editAction(Article $article){
        $this->get('schuma_user.security_service')
            ->userIsAuthorOrAdminOrThrowAccessDeniedException($article);

        $form = $this->createForm(new ArticleEditType, $article);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_blog_articles'));
        }

        return $this->render
            ('SchumaBlogBundle:Article:add.html.twig',
                array('form'=> $form->createView() ));
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Article $article){
        $comment = new Comment();
        $commentForm = $this->createForm(new CommentType, $comment);

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        if($commentForm->handleRequest($request)->isValid()){
            $comment->setAuthor($this->getUser());
            $comment->setArticle($article);
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_blog_get_article',
                array('id' => $article->getId() ) ));
        }

        $commentList = $em
            ->getRepository('SchumaBlogBundle:Comment')
            ->getListByArticle($article);

        $commentNumber = count($commentList);

        return $this->render(
            ('SchumaBlogBundle:Article:get.html.twig'),
            array('article' => $article,
                'comments' => $commentList,
                'commentForm'  => $commentForm->createView(),
                'number' => $commentNumber,
            ));
    }

    /**
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws AccessDeniedException
     */
    public function deleteAction(Article $article){
        $this->get('schuma_user.security_service')
            ->userIsAuthorOrAdminOrThrowAccessDeniedException($article);

        $this->getDoctrine()->getManager()->remove($article);

        return $this->redirect($this->generateUrl('schuma_blog_all_article'));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayNewsAction(){
        $news = $this->getDoctrine()->getManager()
            ->getRepository('SchumaBlogBundle:Article')
            ->getTwoLast();

        return $this->render(
            ('SchumaBlogBundle::news.html.twig'),
                array('news' => $news));
    }
}
