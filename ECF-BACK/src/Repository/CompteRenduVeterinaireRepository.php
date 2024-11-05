<?php

namespace App\Repository;

use App\Entity\CompteRenduVeterinaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteRenduVeterinaire>
 *
 * @method CompteRenduVeterinaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteRenduVeterinaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteRenduVeterinaire[]    findAll()
 * @method CompteRenduVeterinaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteRenduVeterinaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteRenduVeterinaire::class);
    }

//    /**
//     * @return CompteRenduVeterinaire[] Returns an array of CompteRenduVeterinaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompteRenduVeterinaire
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
