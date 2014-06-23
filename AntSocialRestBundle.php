<?php

namespace Ant\SocialRestBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Ant\SocialRestBundle\Entity\AntDateTimeType;
use Doctrine\DBAL\Types\Type;

class AntSocialRestBundle extends Bundle
{
	public function boot()
	{
		/* @var $em \Doctrine\ORM\EntityManager */
		$entityManager = $this->container->get('doctrine.orm.entity_manager');
		
		if( ! Type::hasType(AntDateTimeType::ANT_DATE_TIME_TYPE)) {
			Type::addType(AntDateTimeType::ANT_DATE_TIME_TYPE, 'Ant\SocialRestBundle\Entity\AntDateTimeType');
				$entityManager
					->getConnection()
					->getDatabasePlatform()
					->registerDoctrineTypeMapping('antDateTime', AntDateTimeType::ANT_DATE_TIME_TYPE);
		}
	}
}