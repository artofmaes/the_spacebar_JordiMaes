<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PDO_Manager;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    private $pdoManager;

    public function __construct(PDO_Manager $pdoManager)
    {
        $this->pdoManager = $pdoManager;
    }

    /**
     * @Route("/steden", name="steden_show")
     */
    public function view()
    {
        $cities = $this->pdoManager->GetData("select * from images INNER JOIN city ON cit_img_id=img_id");

        return $this->render('article/steden.html.twig', ['rows'=>$cities]);
    }

}
