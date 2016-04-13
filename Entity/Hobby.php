<?php
/**
 * User: José Ramón Fernandez Leis
 * Email: jdeveloper.inxenio@gmail.com
 * Date: 13/04/16
 * Time: 8:39
 */

namespace Ant\SocialRestBundle\Entity;

use Ant\SocialRestBundle\Model\Hobby as BaseHobby;
use Doctrine\ORM\Mapping as ORM;

abstract class Hobby extends BaseHobby
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;
}