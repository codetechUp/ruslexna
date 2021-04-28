<?php

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }



    public function searchDoc($mots,$cat,$scat=null,$date=null)
    {
        
        if(!empty($mots) && !empty($cat)){
            if(!empty($scat)){
                if(!empty($date)){
                    return $this->createQueryBuilder('d')
                    ->Where('d.description LIKE :val ')
                    //->andWhere(':cat MEMBER OF d.categories')
                    ->andWhere('d.categorie = :cat ')
                    ->andWhere('d.souscat = :scat ')
                    ->andWhere('d.CreatedAt = :date ')
                    ->setParameter('val', '%'.$mots.'%')
                    ->setParameter('cat', $cat)
                    ->setParameter('scat', $scat)
                    ->setParameter('date', $date)
                    ->getQuery()
                    ->getResult();
                }
                return $this->createQueryBuilder('d')
                ->Where('d.description LIKE :val ')
                //->andWhere(':cat MEMBER OF d.categories')
                ->andWhere('d.categorie = :cat ')
                ->andWhere('d.souscat = :scat ')
                ->setParameter('val', '%'.$mots.'%')
                ->setParameter('cat', $cat)
                ->setParameter('scat', $scat)
                ->getQuery()
                ->getResult();
            }else{
                
                if(!empty($date)){
                    return $this->createQueryBuilder('d')
                    ->Where('d.description LIKE :val ')
                    //->andWhere(':cat MEMBER OF d.categories')
                    ->andWhere('d.categorie = :cat ')
                    ->andWhere('d.CreatedAt = :date ')
                    ->setParameter('val', '%'.$mots.'%')
                    ->setParameter('cat', $cat)
                    ->setParameter('date', $date)
                    ->getQuery()
                    ->getResult();
                }
            return $this->createQueryBuilder('d')
            ->Where('d.description LIKE :val ')
            //->andWhere(':cat MEMBER OF d.categories')
            ->andWhere('d.categorie = :cat ')
            ->setParameter('val', '%'.$mots.'%')
            ->setParameter('cat', $cat)
            ->getQuery()
            ->getResult();
            }
            
            
        ;
    }else{
        if(!empty($date)){
            return $this->createQueryBuilder('d')
            ->Where('d.description LIKE :val ')
            ->andWhere('d.CreatedAt = :date ')
            //->andWhere(':cat MEMBER OF d.categories')
            ->setParameter('val', '%'.$mots.'%')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;
        }
        return $this->createQueryBuilder('d')
        ->Where('d.description LIKE :val ')
        //->andWhere(':cat MEMBER OF d.categories')
        ->setParameter('val', '%'.$mots.'%')
        ->getQuery()
        ->getResult()
    ;
}



    }
    public function findByCat($value)
{
    return $this->createQueryBuilder('d')
        ->andWhere('d.categorie = :val')
        ->setParameter('val', $value)
        ->orderBy('d.id', 'ASC')
        ->getQuery()
        ->getResult()
    ;
}


    // /**
    //  * @return Document[] Returns an array of Document objects
    //  */
    /*
    public function findByCat($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Document
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
