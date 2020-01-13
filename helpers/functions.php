<?php
/**
 * Generates random integer within a given range
 * not equal to current integer
 * @param $min int
 * @param $max int
 * @param $current int integer to compare against
 * @return int $number
 */
function generateUniqueRandomNumber(int $min, int $max, int $current)
{
    while ($number = rand($min, $max)) {
        if ($number !== $current) {
            break;
        }
    }
    return $number;
}
/**
 * Creates prepared statement with SQL query and data array
 *
 * @param $link mysqli connection resource
 * @param $sql string SQL query with placeholders instead of values
 * @param array $data Placeholders insertion data
 *
 * @return mysqli_stmt Prepared statement
 */
function db_get_prepare_stmt(mysqli $link, string $sql, array $data = [])
{
    try {
        $stmt = mysqli_prepare($link, $sql);
    }
    catch (\mysqli_sql_exception $error) {
        throw $error;
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}
