<?php


namespace App\Controller\front;

use App\Entity\Like;
use App\Repository\LikeRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController {

     /**
     * @Route("/front/categorys/", name="front_list_category")
     */
    public function listCategory(CategoryRepository $categoryRepository)
    {
        $categorys = $categoryRepository->findAll();

        return $this->render("front/categorys.html.twig", ['categorys' => $categorys]);
    }

    /**
     * @Route("front/category/{id}", name="front_show_category")
     */
    public function showCategory(CategoryRepository $categoryRepository, $id)
    {
        $category = $categoryRepository->find($id);

        return $this->render("front/category.html.twig", ['category' => $category]);
    }
}