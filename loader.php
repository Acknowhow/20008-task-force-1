<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
ini_set('error_log', __DIR__ . '/error.log');
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

use TaskForce\utils\FileLoader;
use TaskForce\utils\DatabaseHelper;
use TaskForce\exceptions\SourceFileException;
use TaskForce\exceptions\FileFormatException;

require_once 'helpers/functions.php';
require_once 'helpers/queries.php';
require_once 'vendor/autoload.php';

const MIN_ID = 1;
$data_array = [];

$loader_parameters = [
    '/data/categories.csv' => ['name', 'icon'],
    '/data/cities.csv' => ['city', 'lat', 'long'],
    '/data/opinions.csv' => ['dt_add', 'rate', 'description'],
    '/data/profiles.csv' => ['address', 'bd', 'about',
        'phone', 'skype'
    ],
    '/data/replies.csv' => ['dt_add', 'rate', 'description'],
    '/data/tasks.csv' => ['dt_add', 'category_id', 'description',
        'expire', 'name', 'address', 'budget', 'lat', 'long'
    ],
    '/data/users.csv' => ['email', 'name', 'password', 'dt_add'
    ]
];

$loader = new FileLoader(__DIR__ . '/data/categories.csv',
    ['name', 'icon']);

foreach ($loader_parameters as $directory => $columns ) {
    $loader = new FileLoader(__DIR__ . $directory, $columns);

    try {
        $loader->import();
        $file = $loader->getData();
    }
    catch (SourceFileException $error) {
        error_log("Не удалось обработать csv файл: " .
            $error->getMessage());
    }
    catch (FileFormatException $error) {
        error_log("Неверная форма файла импорта: " .
            $error->getMessage());
    }

    $directory = substr($directory, 6, -4);
    $data_array[$directory] = $file;
}

/**
 * Adding random cities_ids into users array
 */
$cities_count = count($data_array['cities']);
$cities_ids = range(MIN_ID, $cities_count);
shuffle($cities_ids);

foreach ($data_array['users'] as $user => $userValue) {

    $data_array['users'][$user][] =
        $cities_ids[rand(MIN_ID, $cities_count - 1)];
}
/**
 * Adding client_ids and contractor_ids into tasks
 */
$users_count = count($data_array['users']);
$users_ids = range(MIN_ID, $users_count);
shuffle($users_ids);

foreach ($data_array['tasks'] as $task => $taskValue) {
    $userId = rand(MIN_ID, $users_count - 1);

    $data_array['tasks'][$task][] = $userId;
    $data_array['tasks'][$task][] = generateUniqueRandomNumber(
        MIN_ID, $users_count, $userId);
}

try {
    $connect = new DatabaseHelper('localhost','root',
        'testpassword2021', 'task_force');

    $connect->executeQuery($tasks_drop_sql);
    $connect->executeQuery($users_drop_sql);
    $connect->executeQuery($cities_drop_sql);
    $connect->executeQuery($categories_drop_sql);

    $connect->executeQuery($categories_create_sql);
    $connect->executeQuery($cities_create_sql);
    $connect->executeQuery($users_create_sql);
    $connect->executeQuery($tasks_create_sql);

    foreach ($data_array['categories'] as $category) {
        $connect->executeQuery($categories_insert_sql, $category);
    }

    foreach ($data_array['cities'] as $city) {
        $connect->executeQuery($cities_insert_sql, $city);
    }

    foreach ($data_array['users'] as $user) {
        $connect->executeQuery($users_insert_sql, $user);
    }

    foreach ($data_array['tasks'] as $task) {
        $connect->executeQuery($tasks_insert_sql, $task);
    }

} catch (Exception $error) {
    error_log($error->getMessage());
}




