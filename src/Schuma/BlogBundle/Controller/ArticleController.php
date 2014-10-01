<?php
// src/Schuma/BlogBundle/Controller/ArticleController.php

namespace Schuma\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\BlogBundle\Entity\Article;
use Schuma\BlogBundle\Form\ArticleType;
use Schuma\BlogBundle\Form\ArticleEditType;
use Schuma\BlogBundle\Entity\Comment;
use Schuma\BlogBundle\Form\CommentType;


class ArticleController extends Controller{

    public function articlesAction(){
        $listArticles = $this->getDoctrine()->getManager()
                            ->getRepository('SchumaBlogBundle:Article')
                            ->findBy(array(), array('date'=>'DESC'));

        return $this->render
            ('SchumaBlogBundle:Blog:articles.html.twig',
                array('list' => $listArticles ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addArticleAction(){
        $article = new Article();
        $form = $this->createForm(new ArticleType, $article);

        $request = $this->get('request');

        if($request->getMethod() == 'POST'){
            $form->bind($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('schuma_blog_articles'));
            }
        }

        return $this->render
            ('SchumaBlogBundle:Blog:add_article.html.twig',
                array('form'=> $form->createView() ));
    }


    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editArticleAction(Article $article){
        $form = $this->createForm(new ArticleEditType, $article);

        $request = $this->get('request');

        if($request->getMethod() == 'POST'){
            $form->bind($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirect($this->generateUrl('schuma_blog_articles'));
            }
        }

        return $this->render
            ('SchumaBlogBundle:Blog:add_article.html.twig',
                array('form'=> $form->createView() ));
    }


    public function voirArticleAction(Article $article){
        $comment = new Comment();
        $form = $this->createForm(new CommentType, $comment);

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        if($request->getMethod() == 'POST'){
            $form->bind($request);
            if($form->isValid()){
                $comment->setAuthor($this->getUser()->getUsername());
                $comment->setArticle($article);
                $em->persist($comment);
                $em->flush();

                return $this->redirect($this->generateUrl('schuma_blog_voirArticle', $article));
            }
        }

        $listComments = $em
            ->getRepository('SchumaBlogBundle:Comment')
            ->getListByArticle($article);

        $numberComments = $em
            ->getRepository('SchumaBlogBundle:Comment')
            ->getNumberComments($article);

        return $this->render(
            ('SchumaBlogBundle:Blog:view_article.html.twig'),
            array('article' => $article,
                'comments' => $listComments,
                'form'  => $form->createView(),
                'number' => $numberComments,
            ));
    }


    public function displayNewsAction(){
        $news = $this->getDoctrine()->getManager()
            ->getRepository('SchumaBlogBundle:Article')
            ->getTwoLast();

        return $this->render(
            ('SchumaBlogBundle::news.html.twig'),
                array('news' => $news));
    }

}
