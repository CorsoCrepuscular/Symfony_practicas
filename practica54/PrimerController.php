<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Repository\DoctorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class PrimerController extends AbstractController
{
    #[Route('/formulario', name: 'mostrarForm')]
    public function mostrarForm()
    {
        return $this->render('inicio.html.twig');
    }

    #[Route('/ejecutar', name: 'ejecutarInsercion')]
    public function ejecutarInsercion(Request $request, EntityManagerInterface $em)
    {
        
        $hospitalCod    = $request->query->get('txtHospitalCod');
        $apellido       = $request->query->get('txtApellido');
        $especialidad   = $request->query->get('txtEspecialidad');
        $salario        = $request->query->get('txtSalario');

        $doctor = new Doctor();
        $doctor->setHospitalCod($hospitalCod);
        $doctor->setApellido($apellido);
        $doctor->setEspecialidad($especialidad);
        $doctor->setSalario($salario);
        dump($doctor);

        $connection = $em->getConnection();
        $statement = $connection->prepare("CALL insertDoctor(:dato)");
        $statement->bindValue('dato', $doctor);
        $resultado = $statement->executeStatement();

        return $this->render('inicio.html.twig', [
            'mensaje' => 'Registro insertado con éxito'
        ]);
    }
}
