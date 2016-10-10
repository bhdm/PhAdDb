<?php

namespace AppBundle\Form\DataTransformer;

use
    Symfony\Component\Form\DataTransformerInterface,
    Symfony\Component\Form\Exception\TransformationFailedException,
    Doctrine\Common\Persistence\ObjectManager,
    AppBundle\Entity\Spread;

class SpreadToStringTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object to a string (id).
     *
     * @param  Spread|null $spread
     * @return string
     */
    public function transform($spread)
    {
        if (null === $spread) {
            return [];
        }
        $r = [];
        foreach ($spread as $sp){
            $r[] = $sp->getTitle();
        }
        return $r;
    }

    /**
     * Transforms a string (id) to an object (spread).
     *
     * @param  string $id
     *
     * @return Spread|null
     *
     * @throws TransformationFailedException if object (spread) is not found.
     */
    public function reverseTransform($string)
    {
        if (empty($string)) {
            return null;
        }


        $builder = $this->om->createQueryBuilder();
        $builder
            ->select('spread')
            ->from('AppBundle:Spread', 'spread')
            ->where('spread.title = :spreadTitle')
            ->orderBy('spread.title', 'ASC')
            ->setParameter('spreadTitle', $string)
            ->setMaxResults(1);

        $spread = $builder->getQuery()->getOneOrNullResult();

        if (empty($spread)) {
            throw new TransformationFailedException(sprintf(
                'Локация "%s" не найдена!',
                $string
            ));
        }

        return $spread;
    }
}