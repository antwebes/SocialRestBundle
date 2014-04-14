<?php
namespace Ant\SocialRestBundle\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

use Doctrine\Common\Persistence\ObjectManager;

class BirthdayToDateTransformer implements DataTransformerInterface
{

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($birthday)
    {
    	if (null === $birthday) {
    		return '';
    	}
     
        return $birthday->format('D M d o');
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $number
     *
     * @return Issue|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($birthday)
    {
        if (!$birthday) {
            return null;
        }

        try{
            $d = new \DateTime($birthday);
             
            $d->format('D M d o');
             
            return $d;
        }catch(\Exception $e){
            return $birthday;
        }
    }
}