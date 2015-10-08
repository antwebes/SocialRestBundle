<?php
/*
 * This file is part of the  apiChatea package.
 *
 * (c) Ant web <ant@antweb.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ant\SocialRestBundle\ModelManager;

use Ant\SocialRestBundle\EntityManager\VisitManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class VisitManagerTest
 *
 * @package Ant\SocialRestBundle\ModelManager
 */
class VisitManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function findVoyeursOf()
    {
        $mockPaginator = $this->getMockBuilder('Doctrine\ORM\Tools\Pagination\Paginator')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $profile = new TestParticipant();


        $stub = $this->getMockForAbstractClass('Ant\SocialRestBundle\ModelManager\VisitManager');
        $stub->expects($this->any())
            ->method('findVoyeursBy')
            ->with(array('participantVoyeur'=>1),array('visitDate'=>'desc'),1)
            ->will($this->returnValue($mockPaginator));

        $this->assertInstanceOf(Paginator::class,$stub->findVoyeursOf($profile,1,'visitDate=desc'));
    }
}

class TestParticipant implements \Ant\SocialRestBundle\Model\ParticipantInterface
{
    public function getId()
    {
        return 1;
    }
}