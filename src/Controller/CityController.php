<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use PDO;

class CityController extends AbstractController
{
    //DB Params
    private $host = 'localhost';
    private $db_name = 'php2stedensteven';
    private $username = 'root';
    private $password = 'Xrkwq349';
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
    }

    //ALLES VOOR DE CITIES PAGINA
    /**
     * @Route("/steden", name="steden_show")
     */
    public function getSteden(){

        $stm = $this->pdo->prepare('SELECT * FROM city INNER JOIN images on cit_img_id=img_id');
        $stm->execute();
        $rows = $stm->fetchAll(\PDO::FETCH_ASSOC);
//        dump($rows); die;
        return $this->render('article/steden.html.twig', ['rows'=>$rows]);
    }
}