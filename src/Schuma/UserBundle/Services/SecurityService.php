<?php
/**
 * Created by schuma
 * Date: 17/08/15
 * Time: 07:05
 */

namespace Schuma\UserBundle\Services;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Schuma\BlogBundle\Model\Writable;

class SecurityService extends ContainerAware
{
    /**
     * @param Writable $writable
     * @param string $role
     * @throws AccessDeniedException
     */
    public function userIsAuthorOrAdminOrThrowAccessDeniedException(Writable $writable, $role="ROLE_ADMIN") {
        if (false === $this->container->get('security.context')->isGranted($role)
                && $this->container->get('security.context')->getToken()->getUser() != $writable->getAuthor()) {
            throw new AccessDeniedException("Vous n'avez pas les droits nécessaires");
        }
    }
}
