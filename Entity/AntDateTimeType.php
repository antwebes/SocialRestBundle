<?php 

namespace Ant\SocialRestBundle\Entity;

use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Platforms\AbstractPlatform;


class AntDateTimeType extends DateTimeType
{
	CONST ANT_DATE_TIME_TYPE = 'AntDateTimeType';
	
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $dateTime = parent::convertToPHPValue($value, $platform);

        if ( ! $dateTime) {
            return $dateTime;
        }

        return new AntDateTime('@' . $dateTime->format('U'));
    }

    public function getName()
    {
        return 'AntDateTimeType';
    }
}