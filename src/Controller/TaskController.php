<?php


namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    public function GetConnection()
    {
        $dsn = "mysql:host=localhost;dbname=php2stedensteven";
        $user = "root";
        $passwd = "Xrkwq349";


        $pdo = new \PDO($dsn, $user, $passwd);
        return $pdo;
    }

    //ALLES VOOR DE TAKENPAGINA - GET EN POST
    /**
     * @Route("/api/taken", name="taken_show", methods={"GET"})
     */
    public function getTaken(){
        $pdo = $this->GetConnection();
        $stm = $pdo->prepare('SELECT * FROM taak');
        $stm->execute();
        $rows = $stm->fetchAll(\PDO::FETCH_ASSOC);
        return new JsonResponse($rows);
    }
    /**
     * @Route("/api/taken", methods={"POST"})
     */
    public function addData(){
        $pdo = $this->GetConnection();
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
        $stmt = $pdo->prepare($query);


        if ($stmt->execute()) return new JsonResponse('Ding! Taak aangemaakt!');
        else {
            echo $stmt->errorInfo();
            return new JsonResponse('Oeps! Iets verkeerd gedaan?');
        }

    }

    //ALLES VOOR DE SPECIFIEKE TAKENPAGINA - GET, PUT EN DELETE
    /**
     * @Route("/api/taak/{slug}", name="spectaak_show", methods={"GET"})
     */
    public function getTaak($slug)
    {
        $pdo = $this->GetConnection();
        $stm = $pdo->prepare('SELECT * FROM taak where taa_id = "'.$slug.'"');
        $stm->execute();
        $rows = $stm->fetchAll(\PDO::FETCH_ASSOC);
        return new JsonResponse($rows);
    }

    //PUT
    /**
     * @Route("/api/taak/{slug}", methods={"PUT"})
     */
    public function updateData($slug){
        $pdo = $this->GetConnection();
        $data = json_decode(file_get_contents('php://input'));

        $taa_id = htmlentities($slug);
        $taa_omschr = htmlentities($data->taa_omschr);
        $taa_datum = htmlentities($data->taa_datum);

        $query = "UPDATE taak SET taa_omschr = '$taa_omschr', taa_datum = '$taa_datum' where taa_id = '$taa_id'";
        $stmt = $pdo->prepare($query);

        if ($stmt->execute()) return new JsonResponse('Ding! Taak werd aangepast.') ;
        else {
            echo $stmt->errorInfo();
            return new JsonResponse('Oeps! Iets verkeerd gedaan tijdens het updaten?');
        }
    }

    //DELETE
    /**
     * @Route("/api/taak/{slug}", methods={"DELETE"})
     */
    public function deleteData($slug){
        $pdo = $this->GetConnection();
        //clean user-input
        $taa_id = htmlentities($slug);

        $query = "DELETE FROM taak where taa_id = '$taa_id'";
        $stmt = $pdo->prepare($query);
        if ($stmt->execute()) return new JsonResponse('Ding! Taak werd verwijderd.');
        else {
            echo $stmt->errorInfo();
            return new JsonResponse('Oeps! Iets verkeerd gedaan tijdens de verwijdering?');
        }
    }

}