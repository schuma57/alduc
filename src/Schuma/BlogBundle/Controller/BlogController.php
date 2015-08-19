<?php

namespace Schuma\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class BlogController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainAction(){
        return $this->render('::index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function masterAction(){
        return $this->render('SchumaBlogBundle:Blog:master.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function associationAction(){
        return $this->render('SchumaBlogBundle:Blog:association.html.twig');
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function promoAction(){
        return $this->render('SchumaBlogBundle:Blog:promo.html.twig');
    }

}
