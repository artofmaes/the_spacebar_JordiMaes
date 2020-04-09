<?php


namespace App\Service;
use PDO;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataService
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

    public function GetDataAPI( $sql )
    {
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
        return new JsonResponse($rows);
    }
    public function ExecuteSQLAPI( $sql , $true , $false)
    {
        $stm = $this->pdo->prepare($sql);

        if ( $stm->execute() ) return $true;
        else {
            echo $stm->errorInfo();
            return $false;
        }
    }

    public function GetDataSteden( $sql )
    {
        $stm = $this->pdo->prepare($sql);
        $stm->execute();

        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }


}