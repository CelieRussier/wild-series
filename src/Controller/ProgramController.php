<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

Class ProgramController extends AbstractController
{
    #[Route('/program', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series', 'programs' => $programs
         ]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'program_show')]
    public function show(ProgramRepository $programRepository, int $id): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program
         ]);
    }
}