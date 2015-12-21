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
use Chatea\SocialBundle\Entity\Profile;
use Chatea\SocialBundle\Entity\Visit;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class VisitManagerTest
 *
 * @package Ant\SocialRestBundle\ModelManager
 */
class VisitManagerTest extends \PHPUnit_Framework_TestCase
{
    private $dispatcher;

    private $profileManager;

    private $visitManager;

    protected function setUp()
    {
        parent::setUp();

        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->profileManager = $this->getMockForAbstractClass(
            'Ant\SocialRestBundle\ModelManager\ProfileManager',
            array($this->dispatcher),
            '',
            true,
            true,
            true,
            array('addVisit')
        );


        $this->visitManager = $this->getMockForAbstractClass('Ant\SocialRestBundle\ModelManager\VisitManager', array($this->profileManager));
    }

    /**
     * @test
     */
    public function findVoyeursOf()
    {
        $mockPaginator = $this->getMockBuilder('Doctrine\ORM\Tools\Pagination\Paginator')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $profile = new TestParticipant(1, null);

        $this->visitManager->expects($this->any())
            ->method('findVoyeursBy')
            ->with(array('participantVoyeur'=>1),array('visitDate'=>'desc'),1)
            ->will($this->returnValue($mockPaginator));

        $this->assertInstanceOf(Paginator::class,$this->visitManager->findVoyeursOf($profile,1,'visitDate=desc'));
    }

    /**
     * @test
     */
    public function addVisitOfUserWithNoProfile()
    {
        $user = new TestParticipant(1, null);
        $voyeur = new TestParticipant(2, null);

        $visit = new Visit();
        $visit->setParticipant($user);
        $visit->setParticipantVoyeur($voyeur);

        $this->profileManager->expects($this->never())
            ->method('addVisit');

        $this->visitManager->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue('Chatea\SocialBundle\Entity\Visit'));
        $this->visitManager->expects($this->once())
            ->method('findOneVisitBy')
            ->with($this->callback(function($data) use ($user, $voyeur){
                return $data['participantVoyeur'] == $voyeur &&
                    $data['participant'] == $user;
            }))
            ->will($this->returnValue(null));
        $this->visitManager->expects($this->once())
            ->method('doSaveVisit')
            ->with($visit);

        $this->visitManager->addVisit($user, $voyeur);
        $this->assertEquals(0, $visit->getFrequency());
    }

    /**
     * @test
     */
    public function addVisitOfUserWithNoProfileAgain()
    {
        $user = new TestParticipant(1, null);
        $voyeur = new TestParticipant(2, null);

        $visit = new Visit();
        $visit->setParticipant($user);
        $visit->setParticipantVoyeur($voyeur);

        $this->profileManager->expects($this->never())
            ->method('addVisit');

        $this->visitManager->expects($this->never())
            ->method('getClass');
        $this->visitManager->expects($this->once())
            ->method('findOneVisitBy')
            ->with($this->callback(function($data) use ($user, $voyeur){
                return $data['participantVoyeur'] == $voyeur &&
                $data['participant'] == $user;
            }))
            ->will($this->returnValue($visit));
        $this->visitManager->expects($this->once())
            ->method('doSaveVisit')
            ->with($visit);

        $this->visitManager->addVisit($user, $voyeur);
        $this->assertEquals(1, $visit->getFrequency());
    }

    /**
     * @test
     */
    public function addVisitOfUserWithProfile()
    {
        $profile = new Profile();
        $profile->setId(3);

        $user = new TestParticipant(1, $profile);
        $voyeur = new TestParticipant(2, null);

        $visit = new Visit();
        $visit->setParticipant($user);
        $visit->setParticipantVoyeur($voyeur);

        $this->profileManager->expects($this->once())
            ->method('addVisit');

        $this->visitManager->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue('Chatea\SocialBundle\Entity\Visit'));
        $this->visitManager->expects($this->once())
            ->method('findOneVisitBy')
            ->with($this->callback(function($data) use ($user, $voyeur){
                return $data['participantVoyeur'] == $voyeur &&
                    $data['participant'] == $user;
            }))
            ->will($this->returnValue(null));
        $this->visitManager->expects($this->once())
            ->method('doSaveVisit')
            ->with($visit);

        $this->visitManager->addVisit($user, $voyeur);
        $this->assertEquals(0, $visit->getFrequency());
    }
}

class TestParticipant implements \Ant\SocialRestBundle\Model\ParticipantInterface
{
    private $id;
    private $profile;

    public function __construct($id, $profile)
    {
        $this->id = $id;
        $this->profile = $profile;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProfile()
    {
        return $this->profile;
    }
}