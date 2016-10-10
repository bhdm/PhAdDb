<?php

namespace AppBundle\Form\DataTransformer;

use
    Symfony\Component\Form\DataTransformerInterface,
    Symfony\Component\Form\Exception\TransformationFailedException,
    Doctrine\Common\Persistence\ObjectManager,
    AppBundle\Entity\Format;

class FormatToStringTransformer implements DataTransformerInterface
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
     * @param  Format|null $format
     * @return string
     */
    public function transform($format)
    {
        if (null === $format) {
            return '';
        }

        return $format->getTitle();
    }

    /**
     * Transforms a string (id) to an object (format).
     *
     * @param  string $id
     *
     * @return Format|null
     *
     * @throws TransformationFailedException if object (format) is not found.
     */
    public function reverseTransform($string)
    {
        if (empty($string)) {
            return null;
        }


        $builder = $this->om->createQueryBuilder();
        $builder
            ->select('format')
            ->from('AppBundle:Format', 'format')
            ->where('format.title = :formatTitle')
            ->orderBy('format.title', 'ASC')
            ->setParameter('formatTitle', $string)
            ->setMaxResults(1);

        $format = $builder->getQuery()->getOneOrNullResult();

        if (empty($format)) {
            $format = new Format();
            $format->setTitle($string);
            $this->om->persist($format);
            $this->om->flush($format);
            $this->om->refresh($format);
        }

        return $format;
    }
}