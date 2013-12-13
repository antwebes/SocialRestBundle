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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
*
* Must be extended and properly mapped by the end developer.
*
* @author Pablo  <pablo@antweb.es>
*/
abstract class Profile extends BaseProfile
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="text", nullable=true)
	 * @Assert\Length(
	 * 	max = "600")
	 */
	protected $about;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @Assert\Choice(
	 * choices = {"heterosexual", "homosexual", "bisexual"},
	 * message = "profile.sexualOrientation.choice"
	 * )
	 */
	protected $sexualOrientation;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @Assert\Choice(
	 * choices = {"Male", "Female", "Other"},
	 * message = "profile.gender.choice"
	 * )
	 */
	protected $gender;
	
	/**
	 * @var date $birthday
	 *
	 * @ORM\Column(name="birthday", type="date", nullable=true)
	 */
	protected $birthday;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $countVisits=0;
	
	/**
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $youWant;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 *
	 * @Assert\DateTime
	 */
	protected $updatedAt;
	
	/**
	 * @ORM\Column(type="datetime")
	 *
	 * @Assert\Date
	 */
	protected $publicatedAt;
	
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
	
	/*
	 * $birthday string, antes venia como fecha, pero al llegarle string desde la peticion aquí llegaba null
	 */
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