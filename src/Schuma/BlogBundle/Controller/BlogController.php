<?php

// src/Schuma/BlogBundle/Controller/BlogController.php

namespace Schuma\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\BlogBundle\Entity\Article;
use Schuma\BlogBundle\Form\ArticleType;
use Schuma\BlogBundle\Form\ArticleEditType;


class BlogController extends Controller{

    public function mainAction(){
        return $this->render
            ('::base.html.twig');
    }

    public function masterAction(){
        return $this->render
            ('SchumaBlogBundle:Blog:master.html.twig');
    }

    public function associationAction(){
        return $this->render
            ('SchumaBlogBundle:Blog:association.html.twig');
    }


    public function articlesAction(){
        $listArticles = $this->getDoctrine()->getManager()
                            ->getRepository('SchumaBlogBundle:Article')
                            ->findAll();

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


    public function promoAction(){
        return $this->render
            ('SchumaBlogBundle:Blog:promo.html.twig');
    }


    public function voirArticleAction(Article $article){
        return $this->render(
            ('SchumaBlogBundle:Blog:view_article.html.twig'),
            array('article' => $article));
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
