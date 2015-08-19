<?php

namespace Schuma\FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Schuma\BlogBundle\Model\Writable;

/**
 * Class Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Schuma\FaqBundle\Entity\QuestionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Question extends Writable
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Schuma\FaqBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;


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
     * Set title
     *
     * @param string $title
     * @return Question
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Question
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set category
     *
     * @param \Schuma\FaqBundle\Entity\Category $category
     * @return Question
     */
    public function setCategory(\Schuma\FaqBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Schuma\FaqBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }
}
