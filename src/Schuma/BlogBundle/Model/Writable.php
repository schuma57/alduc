<?php
/**
 * Created by schuma
 * Date: 14/08/15
 * Time: 12:35
 */

namespace Schuma\BlogBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Writable
 * @ORM\MappedSuperclass
 */
abstract class Writable
{
    /**
     * @ORM\ManyToOne(targetEntity="Schuma\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $author;


    /**
     * Set author
     *
     * @param \Schuma\UserBundle\Entity\User $user
     * @return Writable
     */
    public function setAuthor(\Schuma\UserBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Schuma\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
