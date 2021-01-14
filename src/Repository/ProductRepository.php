<?php

namespace App\Repository;

use App\Entity\Product;
use App\Data\SearchData;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    /**
     * Récupère les produits en lien avec une recherche
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            6
        );
    }

     /**
     * Récupère le prix minimum et maximum correspondant à une recherche
     * @return integer[]
     */
    public function findMinMax(SearchData $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MAX(p.price) as max')
            ->getQuery()
            ->getScalarResult();
        return [0, (int)$results[0]['max']];
    }

    /*
    * Fonction de recherche sur les produits
    */
    private function getSearchQuery(SearchData $search): QueryBuilder
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
    
            if (!empty($search->min)) {
                $query = $query
                    ->andWhere('p.price >= :min')
                    ->setParameter('min', $search->min);
            }
    
            if (!empty($search->max)) {
                $query = $query
                    ->andWhere('p.price <= :max')
                    ->setParameter('max', $search->max);
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

            return $query;
    }
}
