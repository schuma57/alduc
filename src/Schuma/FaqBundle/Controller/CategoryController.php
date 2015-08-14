<?php

namespace Schuma\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\FaqBundle\Entity\Category;
use Schuma\FaqBundle\Form\CategoryType;

class CategoryController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function allAction(){
        $categoryList = $this->getDoctrine()
            ->getManager()
            ->getRepository('SchumaFaqBundle:Category')
            ->findBy(array(), array('name'=>'ASC'));

        return $this->render('SchumaFaqBundle:Category:all.html.twig', array(
            'list' => $categoryList,
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Category $category){
        return $this->render('SchumaFaqBundle:Category:get.html.twig', array(
            'category' => $category
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(){
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_faq_all_category'));
        }

        return $this->render('SchumaFaqBundle:Category:add.html.twig', array(
            'form'=> $form->createView()
        ));
    }


    public function newCategoryFromAjaxAction(Request $request){
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category,
            array('action' => $this->generateUrl('new_faq_category'),
                'method' => 'POST'));

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $categoryData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($categoryData);
            $em->flush();

            $response = new Response(json_encode([
                'success' => true,
                'id' => $categoryData->getId(),
                'name'  => $categoryData->getName()
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $this->render("SchumaFaqBundle:Category:ajax.html.twig", array(
            'form'  =>  $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Category $category
     */
    public function editAction(Category $category){     //TODO l'auteur doit pouvoir modifier sa question
        $form = $this->createForm(new CategoryType(), $category);

        $request = $this->get('request');

        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('schuma_faq_all_category'));
        }

        return $this->render('SchumaFaqBundle:Category:add.html.twig', array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Category $category){
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return $this->redirect($this->generateUrl('schuma_faq_all_category'));
    }

}
