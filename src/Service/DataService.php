<?php


namespace App\Service;
use Michelf\MarkdownInterface;
use PDO;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataService
{
    //DB Params
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $pdo;

    public function __construct()
    {
        $this->host = 'env(DB_HOST)';
        $this->db_name = 'env(string:DB_NAME)';
        $this->username = 'env(string:DB_USER)';
        $this->password = 'env(string:DB_PASS)';
        dump($this->host, $this->db_name, $this->username, $this->password); die;
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