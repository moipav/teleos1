<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

//    /**
//     * @return Client[] Returns an array of Client objects
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

//    public function findOneBySomeField($value): ?Client
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @param int $clientId
     * @return Client|null
     */
    public function findOneByIdJoinedToTariff(int $clientId): ?Client
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c, t
            FROM App\Entity\Client c
            INNER JOIN c.tariff t
            WHERE c.id =:id'
        )->setParameter('id', $clientId);

        return $query->getOneOrNullResult();
    }

    /**
     * @return mixed
     */
    public function findAllJoinedTariffAndAddress(): mixed
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c, t, a
            FROM App\Entity\Client c
            INNER JOIN c.tariff t
            INNER JOIN c.address a'
        );
        return $query->getResult();
    }

}
