<?php

namespace Schuma\FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Schuma\BlogBundle\Model\Writable;

/**
 * FaqResponse
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Schuma\FaqBundle\Entity\AnswerRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Answer extends Writable
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Schuma\FaqBundle\Entity\Question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;


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
     * Set text
     *
     * @param string $text
     *
     * @return Answer
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
     * Set question
     *
     * @param \Schuma\FaqBundle\Entity\Question $question
     * @return Answer
     */
    public function setQuestion(\Schuma\FaqBundle\Entity\Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Schuma\FaqBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }
}

