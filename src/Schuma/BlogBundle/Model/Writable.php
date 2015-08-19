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
 * @ORM\HasLifecycleCallbacks
 */
abstract class Writable
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @ORM\ManyToOne(targetEntity="Schuma\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $author;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Writable
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

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

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        //$this->date = new \DateTime();
    }
}
