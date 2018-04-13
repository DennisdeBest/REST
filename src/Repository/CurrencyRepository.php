<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\User;

class CurrencyRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return mixed
     */
    public function findAllCurrenciesForUser($user)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.createdBy', 'u')
            ->Select('c.id, c.name, c.amount')
            ->andWhere('c.createdBy = :id')
            ->setParameter('id', $user)
            ->getQuery()
            ->getResult();
    }
}