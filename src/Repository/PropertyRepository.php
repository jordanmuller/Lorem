<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\{
    QueryBuilder,
    Query
};
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\PropertySearch;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * Return all properties which aren't sold yet
     * @return Property[]
     */
    public function findAllVisibleQuery(): Query
    {
        return $this->findVisibleQuery()
            ->getQuery();
    }

    /**
     * Find all properties by p.date desc
     * @return array
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    public function findSearchedVisibleQuery(PropertySearch $propertySearch): Query
    {
        $qb = $this->findVisibleQuery();

        if (!empty($propertySearch->getMaxPrice())) {
            $qb->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $propertySearch->getMaxPrice());    
        }

        if (!empty($propertySearch->getMinSurface())) {
            $qb->andWhere('p.surface >= :minSurface')
                ->setParameter('minSurface', $propertySearch->getMinSurface());
        }

        if (!empty($propertySearch->getOptions())) {
            // Avoid SQL injections
            $k = 0;
            foreach ($propertySearch->getOptions() as $option) {
                $qb = $qb->andWhere(":option$k MEMBER OF p.options")
                    ->setParameter("option$k", $option);
                $k++;
            }
        }
        return $qb->getQuery();
    }

    /**
     * Query to find all unsold properties
     * @return QueryBuilder
     */
    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sold = :sold')
            ->setParameter(':sold', false);
    }
}
