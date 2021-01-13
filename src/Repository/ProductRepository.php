<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /*
    * Fonction de recherche sur les produits
    * Return Product[]
    */
    public function findSearch($search)
    {
        $query = $this
        ->createQueryBuilder('p')
        ->join('p.category', 'c')
        ->join('p.size', 's');

        
        if (!empty($search->q)) {
                $query = $query
                    ->andWhere('p.name LIKE :q')
                    ->setParameter('q', "%{$search->q}%");
            }
    
            if (!empty($search->minPrice)) {
                $query = $query
                    ->andWhere('p.price >= :min')
                    ->setParameter('min', $search->minPrice);
            }
    
            if (!empty($search->maxPrice)) {
                $query = $query
                    ->andWhere('p.price <= :max')
                    ->setParameter('max', $search->maxPrice);
            }
    
            if (!empty($search->promo)) {
                $query = $query
                    ->andWhere('p.isPromo = 1');
            }

            if (!empty($search->size)) {
                $query = $query
                    ->andWhere('c.id IN (:size)')
                    ->setParameter('size', $search->size);
            }
    
            if (!empty($search->category)) {
                $query = $query
                    ->andWhere('c.id IN (:category)')
                    ->setParameter('category', $search->category);
            }

            return $query->getQuery()->getResult();
    }

    private function getSearchQuery(SearchData $search, $ignorePrice = false): QueryBuilder
    {
    }
}
