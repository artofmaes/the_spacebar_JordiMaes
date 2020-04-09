<?php


namespace App\Controller;


use App\Service\DataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    //ALLES VOOR DE TAKENPAGINA - GET EN POST
    /**
     * @Route("/api/taken", name="taken_show", methods={"GET"})
     */
    public function getTaken(DataService $dataService){

        $sql = 'SELECT * FROM taak';
        return $dataService->GetDataAPI($sql);

    }
    /**
     * @Route("/api/taken", methods={"POST"})
     */
    public function addData(DataService $dataService){
        $data = json_decode(file_get_contents('php://input'));
        //zijn de veldjes klaar?
        if (!isset($data->taa_datum) or !isset($data->taa_omschr)) {
            print 'Bruh, vul alles eens in';
            die();

        } else {
            $taa_omschr    = htmlentities($data->taa_omschr);
            $taa_datum     = htmlentities($data->taa_datum);
        }
        $query = "INSERT INTO taak SET taa_datum = '$taa_datum', taa_omschr = '$taa_omschr'";
        $true= new JsonResponse('Ding! Taak aangemaakt!');
        $false= new JsonResponse('Oeps! Iets verkeerd gedaan?');
        return $dataService->ExecuteSQLAPI($query, $true , $false);


    }

    //ALLES VOOR DE SPECIFIEKE TAKENPAGINA - GET, PUT EN DELETE
    /**
     * @Route("/api/taak/{slug}", name="spectaak_show", methods={"GET"})
     */
    public function getTaak($slug, DataService $dataService)
    {
        $sql ='SELECT * FROM taak where taa_id = "'.$slug.'"';
        return $dataService->GetDataAPI($sql);
    }

    //PUT
    /**
     * @Route("/api/taak/{slug}", methods={"PUT"})
     */
    public function updateData($slug, DataService $dataService){

        $data = json_decode(file_get_contents('php://input'));

        $taa_id = htmlentities($slug);
        $taa_omschr = htmlentities($data->taa_omschr);
        $taa_datum = htmlentities($data->taa_datum);

        $query = "UPDATE taak SET taa_omschr = '$taa_omschr', taa_datum = '$taa_datum' where taa_id = '$taa_id'";
        $true = new JsonResponse('Ding! Taak werd aangepast.');
        $false= new JsonResponse('Oeps! Iets verkeerd gedaan tijdens het updaten?');
        return $dataService->ExecuteSQLAPI($query,$true,$false);

    }

    //DELETE
    /**
     * @Route("/api/taak/{slug}", methods={"DELETE"})
     */
    public function deleteData($slug, DataService $dataService){

        //clean user-input
        $taa_id = htmlentities($slug);

        $query = "DELETE FROM taak where taa_id = '$taa_id'";
        $true= new JsonResponse('Ding! Taak werd verwijderd.');
        $false=  new JsonResponse('Oeps! Iets verkeerd gedaan tijdens de verwijdering?');
        return $dataService->ExecuteSQLAPI($query,$true,$false);
    }

}