<?php


namespace App\Controller;



use App\Service\PDO_Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class TaskController extends AbstractController
{
    private $pdoManager;
    private $apiLogger;

    public function __construct( PDO_Manager $pdoManager, LoggerInterface $apiLogger)
    {
        $this->pdoManager = $pdoManager;
        $this->apiLogger = $apiLogger;
    }

    private function log()
    {
        $request = Request::createFromGlobals();

        $this->apiLogger->log( LogLevel::INFO, $request->getPathInfo(), [
            'URI' => $request->getPathInfo(),
            'method' => $request->getMethod(),
            'querystring' => $request->getQueryString()
        ]);
    }



    //ALLES VOOR DE TAKENPAGINA - GET EN POST
    /**
     * @Route("/api/taken", name="taken_show", methods={"GET"})
     */
    public function getTasks()
    {
        $this->log();
        $rows = $this->pdoManager->GetData( "select * from taak" );
        return $this->json([ 'rows' => $rows ]);
    }

    /**
     * @Route("/api/taken", methods={"POST"})
     */
    public function createTask()
    {
        $ins = "insert into taak SET taa_datum='" . $_POST['datum'] . "' , taa_omschr='" . $_POST['omschr'] . "'";
        $result = $this->pdoManager->ExecuteSQL($ins);
        return $this->json([ 'result' => $result ]);
    }

    //ALLES VOOR DE SPECIFIEKE TAKENPAGINA - GET, PUT EN DELETE
    /**
     * @Route("/api/taak/{slug}", name="spectaak_show", methods={"GET"})
     */
    public function getOneTask($slug)
    {
        $this->log();
        $rows = $this->pdoManager->GetData( "select * from taak where taa_id= '$slug'" );
        return $this->json([ 'rows' => $rows ]);
    }

    //PUT
    /**
     * @Route("/api/taak/{slug}", methods={"PUT"})
     */
    public function updateTask($slug)
    {
        $data = json_decode(file_get_contents("php://input"));

        $ins = "update taak SET taa_datum='" . $data->datum . "' , taa_omschr='" . $data->omschr . "' where taa_id='$slug'";
        $result = $this->pdoManager->ExecuteSQL($ins);
        return $this->json([ 'result' => $result ]);
    }

    //DELETE
    /**
     * @Route("/api/taak/{slug}", methods={"DELETE"})
     */
    public function deleteTask($slug)
    {
        $del = "delete from taak where taa_id='$slug'";
        $result = $this->pdoManager->ExecuteSQL($del);
        return $this->json([ 'result' => $result ]);
    }


}