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

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function promoteAction(User $user)
    {
        if(!$user->hasRole('ROLE_AUTHOR'))
            $user->addRole('ROLE_AUTHOR');
        else if(!$user->hasRole('ROLE_ADMIN'))
            $user->addRole('ROLE_ADMIN');
        else
            $user->setSuperAdmin(true);

        $this->get('fos_user.user_manager')->updateUser($user);

        return $this->redirect($this->generateUrl('schuma_user_all_user'));
    }

    /**
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function demoteAction(User $user)
    {
        if($user->isSuperAdmin())
            $user->setSuperAdmin(false);
        else if($user->hasRole('ROLE_ADMIN'))
            $user->removeRole('ROLE_ADMIN');
        else
            $user->removeRole('ROLE_AUTHOR');

        $this->get('fos_user.user_manager')->updateUser($user);

        return $this->redirect($this->generateUrl('schuma_user_all_user'));
    }
}
