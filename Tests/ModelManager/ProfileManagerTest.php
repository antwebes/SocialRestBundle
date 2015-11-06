<?php

namespace Ant\SocialRestBundle\ModelManager;

class DateHelper
{
    public static $now = null;
    public static $calledDateFunction = false;
}

if(!function_exists('Ant\SocialRestBundle\ModelManager\date')) {
    function date($format)
    {
        if(DateHelper::$now != null){
            DateHelper::$calledDateFunction = true;
            return \date($format, DateHelper::$now);
        }else{
            return \date($format);
        }
    }
}

class ProfileManagerTest extends \PHPUnit_Framework_TestCase
{
    private $modelManager;
    private $dispatcher;

    public function setUp()
    {
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->modelManager = $this->getMockForAbstractClass('Ant\SocialRestBundle\ModelManager\ProfileManager', array($this->dispatcher));
    }

    public function testUpate()
    {
        DateHelper::$now = strtotime('2013-08-30T15:01:01+0200');
        $profile = $this->getMock('Ant\SocialRestBundle\Model\ProfileInterface');
        $profile->expects($this->once())
            ->method('setUpdatedAt');

        $this->modelManager->update($profile);
        $this->assertTrue(DateHelper::$calledDateFunction);
        DateHelper::$calledDateFunction = false;
    }

    public function testUpatePatch()
    {
        DateHelper::$now = strtotime('2013-08-30T15:01:01+0200');
        $profile = $this->getMock('Ant\SocialRestBundle\Model\ProfileInterface');
        $profile->expects($this->once())
            ->method('setUpdatedAt');

        $this->modelManager->updatePatch(array('seeking' => 'heterosexual', 'birthday' => '1964-04-04'),$profile);
        $this->assertTrue(DateHelper::$calledDateFunction);
        DateHelper::$calledDateFunction = false;
    }

    public function testSave()
    {
        $profile = $this->getMock('Ant\SocialRestBundle\Model\ProfileInterface');
        $profile->expects($this->never())
            ->method('setUpdatedAt');

        $this->modelManager->save(null, $profile);
    }

    public function testAddVisit()
    {
        $profile = $this->getMock('Ant\SocialRestBundle\Model\ProfileInterface');
        $profile->expects($this->once())
            ->method('getCountVisits')
            ->willReturn(5);
        $profile->expects($this->once())
            ->method('setCountVisits')
            ->with(6);
        $this->modelManager->expects($this->once())
            ->method('doSave')
            ->with($profile);

        $this->modelManager->addVisit($profile);
    }
}