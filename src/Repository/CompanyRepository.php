<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function save(Company $entity): bool
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity->getId() > 0;
    }

    public function remove(Company $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function update(int $id, array $params): int
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $nbUpdatedRows = $queryBuilder->update()
            ->set('c.name', ':companyName')
            ->where('c.id = :companyId')
            ->setParameter('companyName', $params['name'])
            ->setParameter('companyId', $id)
            ->getQuery()
            ->execute();

        return $nbUpdatedRows;
    }

    public function select(): array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $selectedRows = $queryBuilder
            ->getQuery()
            ->getArrayResult();

        return $selectedRows;
        
    }

    public function selectById(int $id): array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $companyById = $queryBuilder
            ->select('c.name')
            ->where("c.id = $id")
            ->getQuery()
            ->getResult()
        ;

        return $companyById;
    }

    public function selectByName(string $name): array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $companyByName = $queryBuilder
            ->select('c.name')
            ->where("c.name = $name")
            ->getQuery()
            ->getResult()
        ;
        return $companyByName;
    }

    public function selectByNameLike(string $name): array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $companyByName = $queryBuilder
            ->select('c.name')
            ->where('c.name LIKE :name')
            ->getQuery()
            ->getResult()
        ;
        return $companyByName;
    }

//    /**
//     * @return Company[] Returns an array of Company objects
//     */
//     public function findByExampleField($value): array
//     {
//         return $this->createQueryBuilder('c')
//         ->andWhere('c.id = :val')
//         ->setParameter('val', $value)
//         ->orderBy('c.id', 'ASC')
//         ->setMaxResults(10)
//         ->getQuery()
//         ->getResult()
//         ;
//     }

//     public function findOneBySomeField($value): ?Company
//     {
//         return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//         ;
//     }
}
