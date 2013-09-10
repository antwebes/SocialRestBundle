<?php

namespace Ant\SocialRestBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType
{
	private $profileClass;
	
	public function __construct($profileClass)
	{
		$this->profileClass = $profileClass;
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('about')
            ->add('sexualOrientation')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(        	
            'data_class' => $this->profileClass,
        	'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return "ant_social_rest_profile";
    }
}