<?php

namespace App\Repository;

use App\Entity\Jobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Jobs>
 *
 * @method Jobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jobs[]    findAll()
 * @method Jobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jobs::class);
    }
    
    /**
     * add to db
     *
     * @param  mixed $entity
     * @return bool
     */
    public function save(Jobs $entity): bool
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity->getId() > 0;
    }
    
    /**
     * delete from db
     *
     * @param  mixed $entity
     * @return void
     */
    public function remove(Jobs $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
    
    /**
     * querry builder to update
     *
     * @param  mixed $id
     * @param  mixed $params
     * @return int
     */
    public function update(int $id, array $params): int
    {
        $queryBuilder = $this->createQueryBuilder('j');

        $queryBuilder->update()
        ->where('j.id = :jobId')
        ->setParameter('jobId', $id);
        if (!empty($params['name'])) {
            $queryBuilder->set('j.name', ':jobName');
            $queryBuilder->setParameter('jobName', $params['name']);
        }

        if (!empty($params['description'])) {
            $queryBuilder->set('j.description', ':jobDescription');
            $queryBuilder->setParameter('jobDescription', $params['description']);
        }
        if (!empty($params['active'])) {
            $queryBuilder->set('j.active', ':jobActive');
            $queryBuilder->setParameter('jobActive', $params['active']);
        }
        if (!empty($params['priority'])) {
            $queryBuilder->set('j.priority', ':jobPriority');
            $queryBuilder->setParameter('jobPriority', $params['priority']);
        }

         $nbUpdatedRows = $queryBuilder->getQuery()->execute();

        return $nbUpdatedRows;
    }
    
    /**
     * querry builder to select all
     *
     * @return array
     */
    public function select(): array
    {
        $queryBuilder = $this->createQueryBuilder('j');

        $selectedRows = $queryBuilder
            ->getQuery()
            ->getResult();

        return $selectedRows;
    }
    
    /**
     * querry builder to select by ID
     *
     * @param  mixed $id
     * @return array
     */
    public function selectById(int $id): array
    {
        $queryBuilder = $this->createQueryBuilder('j');

        $jobById = $queryBuilder
            ->where("j.id = :jobId")
            ->setParameter('jobId', $id)
            ->getQuery()
            ->getResult()
        ;

        return $jobById;
    }
    
    /**
     * querry builder to select by a name
     *
     * @param  mixed $name
     * @return array
     */
    public function selectByName(string $name): array
    {
        $queryBuilder = $this->createQueryBuilder('j');

        $jobByName = $queryBuilder
            ->where("j.name = :jobName")
            ->setParameter('jobName', $name)
            ->getQuery()
            ->getResult()
        ;
        return $jobByName;
    }
    
    /**
     * querry builder to select every job with the name LIKE de string
     *
     * @param  mixed $name
     * @return array
     */
    public function selectByNameLike(string $name): array
    {
        $queryBuilder = $this->createQueryBuilder('j');

        $jobByName = $queryBuilder
            ->where('j.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult()
        ;
        return $jobByName;
    }

    //    /**
    //     * @return Jobs[] Returns an array of Jobs objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Jobs
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
