<?php 

namespace Ant\SocialRestBundle\Entity;

class AntDateTime extends \DateTime 
{
	public function __toString()
	{
		return $this->format('yyyy/mm/dd');
	}
}