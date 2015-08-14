<?php
/**
 * Created by schuma
 * Date: 14/08/15
 * Time: 14:28
 */

namespace Schuma\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Schuma\UserBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function allAction(){
        $userList = $this->getDoctrine()
            ->getManager()
            ->getRepository('SchumaUserBundle:User')
            ->findBy(array(), array('username'=>'ASC'));

        return $this->render('SchumaUserBundle:User:all.html.twig', array(
            'list' => $userList,
        ));
    }
}
