<?php


namespace App\Controller;
use App\Service\DataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{

    //ALLES VOOR DE CITIES PAGINA
    /**
     * @Route("/steden", name="steden_show")
     */
    public function getSteden(DataService $dataService){

        $sql = 'SELECT * FROM city INNER JOIN images on cit_img_id=img_id';
        $data = $dataService->GetDataSteden($sql);
        return $this->render('article/steden.html.twig', ['rows'=>$data]);

    }
}