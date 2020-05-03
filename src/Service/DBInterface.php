<?php
namespace  App\Service;

interface DBInterface
{
    /**
     * @param $sql
     * @return array
     */
    public function GetData( $sql );

    /**
     * @param $sql
     * @return ExecuteResult
     */
    public function ExecuteSQL( $sql );

}

class ExecuteResult
{
    public $ok;
    public $rows_affected;
    public $new_id;
}