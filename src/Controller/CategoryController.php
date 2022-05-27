<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

Class CategoryController extends AbstractController
{
    #[Route('/category', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        
        return $this->render('category/index.html.twig', [
            'website' => 'Wild Series', 'categories' => $categories
         ]);
    }

    #[Route('/showcategory/{categoryName}', name: 'category_show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
        $programs = $programRepository->findBy(['category' => $category],
                                                ['id' => 'DESC'], 3);
        $categories = $categoryRepository->findAll();

        if (!$programs) {
            throw $this->createNotFoundException(
                'No programs found in program\'s table.'
            );
        }
        if (!$categories) {
            throw $this->createNotFoundException(
                'No categories found in program\'s table.'
            );
        }

        return $this->render('category/show.html.twig', 
                array('programs' => $programs, 'categories' => $categories, 'category' => $category));
    }
}