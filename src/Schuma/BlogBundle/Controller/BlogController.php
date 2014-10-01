<?php

// src/Schuma/BlogBundle/Controller/BlogController.php

namespace Schuma\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


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


    public function evenementsAction(){
        return $this->render
            ('SchumaBlogBundle:Blog:evenements.html.twig');
    }


    public function promoAction(){
        return $this->render
            ('SchumaBlogBundle:Blog:promo.html.twig');
    }

}
