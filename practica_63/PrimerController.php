<?php
namespace App\Controller;
use App\Entity\Emp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\recursos\Cesta;

class PrimerController extends AbstractController
{
	#[Route('/empleados', name: 'listaEmpleados')]
    public function listaEmpleados(EntityManagerInterface $em, Request $request)
    {
        $datos = $em->getRepository(Emp::class)->findAll();
      
        $miSesion = $request->getSession();
        $existe = $miSesion->has('compra');
        if($existe){
            $datoget = $request->query->get('ape');
            $datoget2 = $request->query->get('sal');
            $mivariable=new Cesta();
            $mivariable->apellido= $datoget;
            $mivariable->salario = $datoget2;        
            $miSesion->set("compra", $mivariable);
        }           

        return $this->render('listado.html.twig', [
            'datos' => $datos
        ]);
    }

    #[Route('/resumen', name: 'resumenEmpleados')]
    public function resumenEmpleados(EntityManagerInterface $em, Request $request)
    {
        $miCompra = $request->getSession()->get("compra");
        dump($miCompra);

       
    }
}