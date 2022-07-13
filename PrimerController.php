<?php

namespace App\Controller;

use App\Entity\Emp;
use App\Repository\EmpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrimerController extends AbstractController
{
    #[Route('/menu', name: 'verMenu')]
    public function verMenu()
    {
        return $this->render('oficios.html.twig');
    }

    #[Route('/elegir', name: 'elegirOficio')]
    public function elegirOficio(Request $request, EntityManagerInterface $em)
    {
        $query = $em->createQuery('SELECT distinct(u.oficio) AS oficio FROM App\Entity\Emp u');


        $oficiosDiferentes = $query->getResult();
        dump($oficiosDiferentes);
        return $this->render('oficios.html.twig', [
            'oficiosDiferentes' => $oficiosDiferentes,
        ]);
        
    }

}