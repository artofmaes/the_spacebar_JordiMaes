<?php

namespace App\Service;

use App\Helper\Dates;
use App\Helper\Strings;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class PDO_Manager implements DBInterface
{
    private $pdo;
    private $sqlLogger;

    use Strings;
    use Dates;
    /**
     * PDO_Manager constructor.
     */
    //public function __construct(
    public function __construct($db_host, $db_user, $db_paswd, $db_db, LoggerInterface $sqlLogger)
    {
        $this->sqlLogger = $sqlLogger;
        //databaseconnectiegegevens goedzetten
        $dbdsn = 'mysql:host='.$db_host.';dbname='.$db_db;
        $this->pdo = new \PDO($dbdsn, $db_user, $db_paswd );
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param $sql
     * @return array
     */
    public function GetData( $sql )
    {
        $this->sqlLogger->log(LogLevel::INFO, "GETDATA: " . $this->strToDatabase($sql) . " | " .$this->strYMD2strDMY("2020-04-01") . "",[]);
        $stm = $this->pdo->prepare($sql);
        $stm->execute();

        $rows = $stm->fetchAll(\PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * @param $sql
     * @return ExecuteResult
     */
    public function ExecuteSQL( $sql )
    {
        $this->sqlLogger->log(LogLevel::INFO, "EXECUTESQL:$sql",[]);
        $executeResult = new ExecuteResult();

        $stm = $this->pdo->prepare($sql);

        $executeResult->ok = $stm->execute();
        $executeResult->rows_affected = $stm->rowCount();
        $executeResult->new_id = $this->pdo->lastInsertId();

        return $executeResult;
    }

}