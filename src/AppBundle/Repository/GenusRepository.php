<?php
/**
 * Created by PhpStorm.
 * User: SamantaI
 * Date: 6/21/2017
 * Time: 12:50 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Genus;
use Doctrine\ORM\EntityRepository;

class GenusRepository extends EntityRepository
{
    /**
     * Return an array of Genus object
     * @return Genus[]
     */
    public function findAllPublishedOrderedBySize()
    {
        return $this->createQueryBuilder('genus')  // the 'genus' part is the table alias
            ->andWhere('genus.isPublished = :isPublished')
            ->setParameter('isPublished', true)
            ->addOrderBy('genus.speciesCount', 'DESC')
            ->getQuery()
            ->execute();
    }
}