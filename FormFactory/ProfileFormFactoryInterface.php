<?php

/**
 * This file is part of the AntSocialRestBundle package.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Ant\SocialRestBundle\FormFactory;

use Symfony\Component\Form\FormInterface;

/**
 * Profile form creator
 *
 * @author Chrysweel
 */
interface ProfileFormFactoryInterface
{
    /**
     * Creates a comment form
     *
     * @return FormInterface
     */
    public function createForm();
}
