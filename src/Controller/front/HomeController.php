<?php


namespace App\Controller\front;


use App\Repository\LikeRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

     /**
     * @Route("/home/", name="home")
     */
    public function home()
    {
        dd('hello');
    }
}