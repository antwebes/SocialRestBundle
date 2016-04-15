<?php

namespace Ant\SocialRestBundle\FormType;

use Ant\SocialRestBundle\Transformer\BirthdayToDateTransformer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class HobbyType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(        	
            'data_class' => $this->getDataClassName(),
        	'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return "social_hobby";
    }

    public abstract function getDataClassName();
}