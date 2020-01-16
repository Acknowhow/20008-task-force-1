<?php
declare(strict_types=1);

namespace TaskForce\Utils;
require_once 'helpers/functions.php';

class DatabaseHelper
{
    private object $db_resource;
    private \mysqli_result $last_result;

    public function __construct(
        string $host, string $login, string $password, string $db)
    {
        try {
            $this->db_resource = new \mysqli($host, $login, $password, $db);
            mysqli_set_charset($this->db_resource, 'utf8');

        } catch (\mysqli_sql_exception $error) {
            throw $error;
        }
    }

    public function executeQuery($sql, $data = []): void {
        $stmt = db_get_prepare_stmt($this->db_resource, $sql, $data);

        try {
            mysqli_stmt_execute($stmt) && $result =
                mysqli_stmt_get_result($stmt);

        } catch (\mysqli_sql_exception $error) {

            throw $error;
        }
    }


    public function getArrayByColumnName($columnName): array {
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
