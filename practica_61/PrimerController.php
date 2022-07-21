<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrimerController extends AbstractController
{

 #[Route('/inicio', name: 'verPagina1')]

 public function verPagina(Request $request)
  {
    $session = $request->getSession();

    $session->set('nombre', 'Benito');
    $session->set('apellido', 'Floro');
    $session->set('edad', 22);
    $session->set('altura', 1.85);

    return $this->render('Inicio.html.twig');

  } 

  #[Route('/pagina2', name: 'verPagina2')]

   public function verPagina2(Request $request)
   {
    $minombre = $request->getSession()->get('nombre');
    $miapellido = $request->getSession()->get('apellido');

    return $this->render('verDatos.html.twig', [
      'nombrevariable' => $minombre,
      'apellidovariable' => $miapellido,
    ]);
 
 
    } 

}