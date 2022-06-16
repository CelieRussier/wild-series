<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\EpisodeRepository;
use App\Service\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

Class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series', 'programs' => $programs
         ]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'program_show')]
    public function show(Program $program): Response
    {
        $seasons = $program->getSeasons();
    
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '. $program->getId() .' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program, 'seasons' => $seasons
         ]);
    }

    #[Route('/program/{program}/season/{season}', name: 'program_season_show')]
    public function showSeason(Program $program, Season $season, EpisodeRepository $episodeRepository): Response
    {
        $episodes = $season->getEpisodes();
        
        return $this->render('season/show.html.twig', [
            'program' => $program, 'season' => $season, 'episodes' => $episodes
         ]);
    }

    #[Route('/program/{program}/season/{season}/episode/{episode}', name: 'program_episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode, EpisodeRepository $episodeRepository): Response
    {
        $episodes = $episodeRepository->findAll();
        
        return $this->render('episode/episode.html.twig', [
            'program' => $program, 'season' => $season, 'episode' => $episode, 'episodes' => $episodes
         ]);
    }

    #[Route('/program/new', name: 'program_form')]
    public function newProgram(Request $request, ProgramRepository $programRepository, Slugify $slugify) : Response
    {
        // Create a new Category Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $programRepository->add($program, true);            
            //true indique à Doctrine de faire la mise à jour dans la BDD
            // Redirect to categories list
            return $this->redirectToRoute('program_index');
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
        }

        // Render the form
        return $this->renderForm('program/new.html.twig', [
            'form' => $form, 'program' => $program
        ]);
    }

}