<?php

/**
* This file is part of the AntewesSocialRestBundle package.
*
* (c) antweb <http://github.com/antwebes/>
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Ant\SocialRestBundle\Entity;

use Ant\SocialRestBundle\Model\Visit as BaseVisit;

use Doctrine\ORM\Mapping as ORM;
/**
*
* Must be extended and properly mapped by the end developer.
*
* @author Pablo  <pablo@antweb.es>
*/
abstract class Visit extends BaseVisit
{	
	protected $participant;
	
	protected $participantVoyeur;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="AntDateTimeType")
	 */
	protected $date;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $frequency=0;
}