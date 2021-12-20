<?php


namespace App\Controller\front;

use App\Entity\Like;
use App\Repository\LikeRepository;
use App\Repository\LicenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LicenceController extends AbstractController {

     /**
     * @Route("/front/licences/", name="front_list_licence")
     */
    public function listLicence(LicenceRepository $licenceRepository)
    {
        $licences = $licenceRepository->findAll();

        return $this->render("front/licences.html.twig", ['licences' => $licences]);
    }

    /**
     * @Route("front/licence/{id}", name="front_show_licence")
     */
    public function showCategory(LicenceRepository $licenceRepository, $id)
    {
        $licence = $licenceRepository->find($id);

        return $this->render("front/licence.html.twig", ['licence' => $licence]);
    }
}