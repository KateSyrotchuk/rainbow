<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EstateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EstateRepository extends EntityRepository
{
    public function getEstateExclusiveWithFiles()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
                SELECT e, f
                FROM AppBundle:Estate e
                LEFT JOIN e.files f
                WHERE (e.exclusive = true)
            ');
        return $query->getResult();

    }

    public function getEstateFromCategory($slug)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
                SELECT e, c, f
                FROM AppBundle:Estate e
                LEFT JOIN e.category c
                LEFT JOIN e.files f
                WHERE (c.title = :slug)
            ');
        $query->setParameter('slug', $slug);
        return $query->getResult();
    }

    public function getEstateWithDistrictComment($slug)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
                SELECT e, d, com, f, cat
                FROM AppBundle:Estate e
                LEFT JOIN e.district d
                LEFT JOIN e.category cat
                LEFT JOIN e.comments com
                LEFT JOIN e.files f
                WHERE (e.slug = :slug)
            ');
        $query->setParameter('slug', $slug);
        return $query->getOneOrNullResult();

    }

    public function getEstatesWithAll()
    {
        return $this->createQueryBuilder('estate')
            ->select('estate, district, file, category')
            ->orderBy('estate.createdAt', 'DESC')
            ->leftJoin('estate.district', 'district')
            ->leftJoin('estate.category', 'category')
            ->leftJoin('estate.files', 'file')
            ->getQuery()
            ->getResult();
    }

    public function getOneEstateWithAll($slug)
    {
        return $this->createQueryBuilder('estate')
            ->select('estate, district, file, category, comment')
            ->where('estate.slug = :slug')
            ->leftJoin('estate.district', 'district')
            ->leftJoin('estate.category', 'category')
            ->leftJoin('estate.comments', 'comment')
            ->leftJoin('estate.files', 'file')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getEstatesOfManager($manager)
    {
        return $this->createQueryBuilder('estate')
            ->select('estate, file')
            ->where('estate.createdBy = :manager')
            ->leftJoin('estate.files', 'file')
            ->setParameter('manager', $manager)
            ->getQuery()
            ->getResult();
    }

    public function findEstatesFromForm($id_category, $id_district, $price_min, $price_max, $except_floor)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
                SELECT e, d, c, f
                FROM AppBundle:Estate e
                LEFT JOIN e.district d
                LEFT JOIN e.files f
                LEFT JOIN e.category c
                WHERE (c.id = :id_category)
                AND (e.firstLastFloor = :except_floor)
                AND (:id_district is null or d.id = :id_district)
                AND (e.price >= :price_min)
                AND (:price_max is null or e.price <= :price_max)
            ');
        $query->setParameter('id_district', $id_district);
        $query->setParameter('id_category', $id_category);
        $query->setParameter('except_floor', $except_floor);
        $query->setParameter('price_min', $price_min);
        $query->setParameter('price_max', $price_max);
        return $query->getResult();
    }
}
