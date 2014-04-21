<?php

/**
 * This file is part of the AntSocialRestBundle package.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ant\SocialRestBundle\FormFactory;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormFactoryInterface;

use Ant\SocialRestBundle\Model\ProfileInterface;
use Ant\SocialRestBundle\FormFactory\BaseFormFactory;

/**
 * ProfileForm factory class.
 *
 * @author Chrysweel
 */
class ProfileFormFactory extends BaseFormFactory implements ProfileFormFactoryInterface
{
	/**
	 * Creates a new form.
	 *
	 * @param ProfileInterface
	 * @return FormInterface
	 */
	public function createForm(ProfileInterface $profile)
	{
		return $this->formFactory->createNamed($this->name, $this->type, $profile);
	}
}