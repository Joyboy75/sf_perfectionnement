<?php

namespace App\Repository;

use App\Entity\Writer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Writer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Writer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Writer[]    findAll()
 * @method Writer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WriterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Writer::class);
    }

    public function searchByTerm($term)
    {
        // QueryBuilder permet de créer des requêtes SQL en PHP
        $queryBuilder = $this->createQueryBuilder('writer');

        $query = $queryBuilder
            ->select('writer') // select sur la table writer
            ->leftJoin('writer.articles', 'article')
            ->where('writer.name LIKE :term') // WHERE de SQL
            ->orWhere('writer.firstname LIKE :term') // OR WHERE de SQL
            ->orWhere('article.title LIKE :term')
            ->orWhere('article.content LIKE :term')
            ->setParameter('term', '%' . $term . '%') // On attribue le term renté et on le sécurise
            ->getQuery();

        return $query->getResult();
    }
    // /**
    //  * @return Writer[] Returns an array of Writer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Writer
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
