<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class PrimerController extends AbstractController
{

    #[Route('/Index', name: 'elegirIdioma')]
    public function elegirIdioma()
    {
        return $this->render('pagina1.html.twig');
    }

	#[Route('/{_locale}/formulario', name: 'verFormulario')]
    public function verFomulario() 
    {
        return $this->render('pagina2.html.twig');  
    }
    
}