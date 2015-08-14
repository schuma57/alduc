<?php

namespace Schuma\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Schuma\BlogBundle\Model\Writable;

/**
 * Class Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Schuma\BlogBundle\Entity\CommentRepository")
 */
class Comment extends Writable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=255)
     */
    private $body;


    /**
     * @ORM\ManyToOne(targetEntity="Schuma\BlogBundle\Entity\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
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
     * Set body
     *
     * @param string $body
     * @return Comment
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * Set article
     *
     * @param \Schuma\BlogBundle\Entity\Article $article
     * @return Comment
     */
    public function setArticle(\Schuma\BlogBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Schuma\BlogBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \Datetime();
    }


}
