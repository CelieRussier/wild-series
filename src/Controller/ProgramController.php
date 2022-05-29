<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\EpisodeRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $episodes = $episodeRepository->findAll();
        
        return $this->render('season/show.html.twig', [
            'program' => $program, 'season' => $season, 'episodes' => $episodes
         ]);
    }

    #[Route('/program/{program}/season/{season}/episode/{episode}', name: 'program_episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        
        return $this->render('season/show.html.twig', [
            'program' => $program, 'season' => $season, 'episode' => $episode
         ]);
    }
}