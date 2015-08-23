<?php

namespace Schuma\FaqBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategorySearchType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', array(
                'class' => 'SchumaFaqBundle:Category',
                'empty_value' => 'Toutes',
                'required' => false,
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'schuma_faqbundle_category_search';
    }
}
