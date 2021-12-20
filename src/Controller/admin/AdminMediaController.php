<?php

namespace App\Controller\admin;


use App\Entity\Media;

use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMediaController extends AbstractController
{
        /**
        * @Route("/admin/create/media", name="admin_create_media")
        */
       public function createMedia( Request $request,
       EntityManagerInterface $entityManagerInterface,
       SluggerInterface $sluggerInterface)
       {
           $media = new Media();
   
           $mediaForm= $this-> createForm(MediaType::class, $media);

           $mediaForm->handleRequest($request);

           if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {
          
            $mediaFile = $mediaForm ->get('src')->getData();

            if ($mediaFile) {
               
                $originalFilename = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $sluggerInterface->slug($originalFilename);
                
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();


                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $media->setSrc($newFilename);
            }
       
   
        $media->setAlt($mediaForm->get('title')->getData());

            $entityManagerInterface->persist($media);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_list_product");
        }

        
return $this->render('admin/mediaform.html.twig', ['mediaForm' => $mediaForm->createView()]);
  
}         
}