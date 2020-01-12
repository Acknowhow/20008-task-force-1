<?php
declare(strict_types=1);

namespace TaskForce\utils;

class DatabaseHelper
{
    private object $db_resource;
    private $last_error = null;
    private $last_result;

    public function __construct($host, $login, $password, $db)
    {
        try {
            $this->db_resource = new \mysqli($host, $login, $password, $db);
            mysqli_set_charset($this->db_resource, 'utf8');

        } catch (\mysqli_sql_exception $error) {
            throw $error;
        }
    }

    public function executeQuery($sql, $data = []) {
        $this->last_error = null;

        $stmt = db_get_prepare_stmt($this->db_resource, $sql, $data);



        if (mysqli_stmt_execute($stmt) &&
            $result = mysqli_stmt_get_result($stmt)) {

            $this->last_result = $result;

            $res = true;

        } else {
            $this->last_error = mysqli_error($this->db_resource);
            $res = false;
        }

        return $res;
    }

    public function executeSafeQuery($sql) {
        mysqli_query($this->db_resource, $sql);
    }

    public function getLastError() {
        return $this->last_error;
    }

    public function getArrayByColumnName($columnName) {
        $arr = [];

        while ($row = mysqli_fetch_assoc($this->last_result)) {
            $arr[] = $row[$columnName];
        };


        return $arr;
    }

    public function getAssocArray() {
        return mysqli_fetch_all($this->last_result, MYSQLI_ASSOC);
    }

    public function getLastId() {
        return mysqli_insert_id($this->db_resource);
    }

}
