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

use Ant\SocialRestBundle\Model\Profile as BaseProfile;

/**
*
* Must be extended and properly mapped by the end developer.
*
* @author Pablo  <pablo@antweb.es>
*/
abstract class Profile extends BaseProfile
{
	public function setGender($gender)
	{
		$this->gender = $gender;
	}
	
	public function getGender()
	{
		return $this->gender;
	}
	
	public function setYouWant($youWant)
	{
		$this->youWant = $youWant;
	}
	
	public function getYouWant()
	{
		return $this->youWant;
	}
	
	public function setBirthday($birthday)
	{
// 		$birthday = "Mon Feb 01 1915 00:00:00 GMT+0100 (WET)";
// 		$d = new \DateTime($birthday);
		
// 		$d->format('D M d o');
		$this->birthday = $birthday;
	}	
	public function getBirthday()
	{
		return $this->birthday;
	}
}