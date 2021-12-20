<?php

namespace App\Controller\admin;

use App\Entity\Licence;
use App\Repository\LicenceRepository;
use App\Form\LicenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminLicenceController extends AbstractController
{
        /**
        * @Route("/admin/licences/", name="admin_list_licence")
        */
       public function listLicence(LicenceRepository $licenceRepository)
       {
           $licences= $licenceRepository->findAll();
   
           return $this->render("admin/licences.html.twig", ['licences' => $licences]);
       }
   
       /**
        * @Route("admin/licence/{id}", name="admin_show_licence")
        */
       public function showLicence(LicenceRepository $licenceRepository, $id)
       {
           $licence = $licenceRepository->find($id);
   
           return $this->render("admin/licence.html.twig", ['licence' => $licence]);
       }
       /**
     * @Route("admin/update/licence/{id}", name="licence_update")
     */
    public function UpdateLicence($id,LicenceRepository $licenceRepository, EntityManagerInterface $entityManagerInterface, Request $request)
   {
       $licence = $licenceRepository->find($id);
       $licenceForm = $this->createForm(LicenceType::class, $licence);

       $licenceForm->handleRequest($request);
       if ( $licenceForm->isSubmitted() && $licenceForm->isValid()) {
           $entityManagerInterface->persist($licence);
           $entityManagerInterface->flush();
       }
       return $this -> render ('admin/licenceUpdate.html.twig', ['licenceForm'=> $licenceForm->createView(),]);
   }
  /**
    * @Route("admin/add/licence", name="licence_add")
    */
    public function addUpdate( EntityManagerInterface $entityManagerInterface, Request $request

    )
   {
      
       $licence= new Licence();
       $licenceForm = $this->createForm(LicenceType::class, $licence);

       $licenceForm->handleRequest($request);
       if ($licenceForm->isSubmitted() && $licenceForm->isValid()) {
          
           $entityManagerInterface->persist($licence);
           $entityManagerInterface->flush();

           return $this->redirectToRoute("admin_list_licence");
       }
       return $this -> render ('admin/licenceUpdate.html.twig', ['licenceForm'=> $licenceForm->createView(),]);
   
    }
   /**
    * @Route("admin/delete/licence/{id}", name="licence_delete")
    */
   public function deleteLicence( $id, LicenceRepository $licenceRepository, EntityManagerInterface $entityManagerInterface

    )
   {
       $licence = $licenceRepository->find($id);
       $entityManagerInterface->remove($licence);
       $entityManagerInterface->flush();
       $this->addFlash(
           'notice',
           'La licence a été supprimée'
       );

       return $this-> redirectToRoute('admin_list_licence');

   }
}

       