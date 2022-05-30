<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

Class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category_index')]
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

    #[Route('/category/new', name: 'category_form')]
    public function newCategory(Request $request, CategoryRepository $categoryRepository) : Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            $categoryRepository->add($category, true);            
            //true indique à Doctrine de faire la mise à jour dans la BDD
            // Redirect to categories list
            return $this->redirectToRoute('category_index');
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
        }

        // Render the form
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }

}