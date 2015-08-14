<?php

namespace Schuma\BlogBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class EventEditType extends EventType
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
        return 'schuma_blogbundle_editevent';
    }
}
