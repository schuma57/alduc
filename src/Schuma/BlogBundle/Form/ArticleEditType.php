<?php

namespace Schuma\BlogBundle\Form;

use Schuma\BlogBundle\Entity\Article;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleEditType extends ArticleType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'schuma_blogbundle_editarticle';
    }
}
