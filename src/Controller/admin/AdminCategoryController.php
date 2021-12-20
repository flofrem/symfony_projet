<?php
namespace App\Controller\admin;

use App\Entity\Like;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\LikeRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategoryController extends AbstractController {

     /**
     * @Route("/admin/categorys/", name="admin_list_category")
     */
    public function listCategory(CategoryRepository $categoryRepository)
    {
        $categorys = $categoryRepository->findAll();

        return $this->render("admin/categorys.html.twig", ['categorys' => $categorys]);
    }

    /**
     * @Route("admin/category/{id}", name="admin_show_category")
     */
    public function showCategory(CategoryRepository $categoryRepository, $id)
    {
        $category = $categoryRepository->find($id);

        return $this->render("admin/category.html.twig", ['category' => $category]);
    }
     /**
     * @Route("admin/update/category/{id}", name="category_update")
     */
    public function categoryUpdate($id,CategoryRepository $categoryRepository, EntityManagerInterface $entityManagerInterface, Request $request

    )
   {
       $category = $categoryRepository->find($id);
       $categoryForm = $this->createForm(categoryType::class, $category);

       $categoryForm->handleRequest($request);
       if ( $categoryForm->isSubmitted() && $categoryForm->isValid()) {
           $entityManagerInterface->persist($category);
           $entityManagerInterface->flush();
       }
       return $this -> render ('admin/categoryUpdate.html.twig', ['categoryForm'=> $categoryForm->createView(),]);
   }
   /**
    * @Route("admin/add/category", name="category_add")
    */
   public function addUpdate( EntityManagerInterface $entityManagerInterface, Request $request

    )
   {
      
       $category = new Category();
       $categoryForm = $this->createForm(CategoryType::class, $category);

       $categoryForm->handleRequest($request);
       if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
          
           $entityManagerInterface->persist($category);
           $entityManagerInterface->flush();

           return $this->redirectToRoute("admin_list_category");
       }
       return $this -> render ('admin/categoryUpdate.html.twig', ['categoryForm'=> $categoryForm->createView(),]);
   
   }
   /**
    * @Route("admin/delete/category/{id}", name="category_delete")
    */
    public function deleteMedia( $id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManagerInterface

    )
   {
       $category = $categoryRepository->find($id);
       $entityManagerInterface->remove($category);
       $entityManagerInterface->flush();
       $this->addFlash(
           'notice',
           'cette categorie a été supprimée'
       );

       return $this-> redirectToRoute('admin_list_category');

   }
  
}

