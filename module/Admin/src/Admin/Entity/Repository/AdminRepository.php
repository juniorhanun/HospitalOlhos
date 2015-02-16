<?php

namespace Admin\Entity\Repository;


use Admin\Entity\Admin;
use Doctrine\ORM\EntityRepository;


/**
 * AdminRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdminRepository extends EntityRepository
{
    public function loginAdmin(Admin $admin, $login, $senha)
    {
        //die("AdminRepository L 17");
        /**
         * @var $adminLogin \Admin\Entity\Admin
         */
        $adminLogin = $this->createQueryBuilder('a')
            ->where('a.login = :b1')
            ->orWhere('a.status = :b2')
            ->setParameter('b1',$login)
            ->setParameter('b2', '1')
            ->getQuery()
            ->getOneOrNullResult();
        if(!empty($adminLogin)){
            $admin->setSalt($adminLogin->getSalt());
            if($admin->encryptSenha($senha) == $adminLogin->getSenha()){
                $adminLogin->setSenha('');
                $adminLogin->setSalt('');
                return $adminLogin;
            }
        }
        return false;

    }

    public function BuscaNomeAdmin($nome)
    {
        /**
         * @var $adminLogin \Admin\Entity\Admin
         */
        $admin = $this->createQueryBuilder('a')
            ->select('a.nome')
            ->where('a.nome like :n1')
            ->setParameter('n1','%'.$nome.'%')
            ->getQuery()
            ->getArrayResult()
        ;
        //var_dump($admin);die("AdminRepository L56");
        return $admin;

    }
}
