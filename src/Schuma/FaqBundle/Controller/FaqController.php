<?php

namespace Schuma\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FaqController extends Controller{


    public function faqAction(){
        return $this->render
            ('SchumaFaqBundle:Faq:faq.html.twig');
    }

}
