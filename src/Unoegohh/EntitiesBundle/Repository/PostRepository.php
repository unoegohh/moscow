<?php

namespace Unoegohh\EntitiesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Unoegohh\UserBundle\Entity\User;

class PostRepository extends EntityRepository
{
    public function addPosts($id)
    {
        $dtStr = date("c", $id);
        $date = new \DateTime($dtStr);
        $qb = $this->createQueryBuilder('u');
        $qb
            ->where($qb->expr()->lt('u.date' ,':date'))
            ->orderBy("u.date", "DESC")
            ->setMaxResults(10)
            ->setParameters(array('date' =>  $date->format("Y-m-d H:i:s")));

        return $qb->getQuery()->getResult();
    }

    public function getPostsBetweenDates( \DateTime $minDate,\DateTime  $maxDate)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->where($qb->expr()->lt('u.date' ,':maxDate'))
            ->andWhere($qb->expr()->gt('u.date' ,':minDate'))
            ->orderBy("u.date", "DESC")
            ->setParameters(array(
                'maxDate' =>  $maxDate->format("Y-m-d H:i:s"),
                'minDate' =>  $minDate->format("Y-m-d H:i:s"),
            ));

        return $qb->getQuery()->getResult();
    }

}