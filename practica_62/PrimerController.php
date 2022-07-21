<?php
namespace App\Controller;
use App\Entity\Enfermo;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class PrimerController extends AbstractController
{
	#[Route('/ingreso', name: 'mostrarIngreso')]
    public function mostrarIngreso ()
    {
        return $this->render('principal.html.twig');
    }

    #[Route('/formulario', name: 'mostrarFormulario')]
    public function mostrarFormulario (Request $request, EntityManagerInterface $em)
    {
        // Comprobar si ya existe el paciente

        $numero = $request->query->get('numeroSS');
        
        $paciente = $em->getRepository(Enfermo::class)->findByNss($numero);
        dump($paciente);
      // Tambien vale:         if (!$paciente) { 
        if ($paciente<>null) { // El paciente ya existe
            return $this->render('principal.html.twig', [
                'mensaje' => 'Ese enfermo ya está ingresado'
            ]);

        } else { // Paciente nuevo
            $session = $request->getSession();
            $session->set('numeroPaciente',$numero);

            return $this->render('formulario.html.twig');
        }
    }

    #[Route('/rellenar', name: 'rellenarFormulario')]
    public function rellenarFormulario (Request $request, EntityManagerInterface $em)
    {
        $miInscripcion = $request->query->get('inscripcionPaciente');
        $miApellido    = $request->query->get('apellidoPaciente');
        $miDireccion   = $request->query->get('direccionPaciente');
        $miNacimiento  = $request->query->get('nacimientoPaciente');
        $miSexo        = $request->query->get('sexoPaciente');
        $miNSS         = $request->getSession()->get('numeroPaciente');
        dump(  $miInscripcion );

        // Llamar al procedimiento
        $connection = $em->getConnection();
        $statement = $connection->prepare("CALL insertEnfermo(:dato1, :dato2, :dato3, :dato4,:dato5,:dato6)");
        $statement->bindValue('dato1', $miInscripcion);
        $statement->bindValue('dato2', $miApellido);
        $statement->bindValue('dato3', $miDireccion);
        $statement->bindValue('dato4', $miNacimiento);
        $statement->bindValue('dato5', $miSexo);
        $statement->bindValue('dato6', $miNSS);
        $resultado= $statement->executeStatement();
/*
        $enfermo = new Enfermo();
        $enfermo->setInscripcion($miInscripcion);
        $enfermo->setApellido($miApellido);
        $enfermo->setDireccion($miDireccion);
        $enfermo->setFechaNac(new DateTime($miNacimiento));
        $enfermo->setSexo($miSexo);
        $enfermo->setNSS($miNSS);  
        dump( $enfermo);
        $em->persist($enfermo);

        $em->flush();
 */       
        return $this->render('principal.html.twig', [
                'mensaje' => 'Alta correcta'
            ]);
    }
}
   

