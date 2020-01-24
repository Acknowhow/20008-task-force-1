<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
ini_set('error_log', __DIR__ . '/error.log');
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

use TaskForce\Utils\FileLoader;
use TaskForce\Utils\DatabaseHelper;
use TaskForce\exceptions\SourceFileException;
use TaskForce\exceptions\FileFormatException;

require_once __DIR__ . '/../../helpers/functions.php';
require_once __DIR__ . '/../../helpers/queries.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/database/credentials.php';

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
    '/data/tasks.csv' => [
        'dt_add', 'category_id', 'description',
        'expire', 'name', 'address', 'budget', 'lat', 'long'
    ],
    '/data/users.csv' => ['email', 'name', 'password', 'dt_add'
    ]
];

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

/****** Shuffling with random index access ******
 *
 * Adding random cities_ids into users array
 */
$cities_count = count($data_array['cities']);
$cities_ids = range(MIN_ID, $cities_count);
shuffle($cities_ids);

foreach ($data_array['users'] as $user => $userValue) {

    $data_array['users'][$user][] =
        $cities_ids[rand(MIN_ID, $cities_count - 1)];
}

$users_count = count($data_array['users']);
$users_ids = range(MIN_ID, $users_count);
shuffle($users_ids);

foreach ($data_array['tasks'] as $task => $taskValue) {
    $userId = rand(MIN_ID, $users_count - 1);
    /**
     * Adding client_ids and contractor_ids into tasks
     */
    $data_array['tasks'][$task][] = $userId;
    $data_array['tasks'][$task][] = generateUniqueRandomNumber(
        MIN_ID, $users_count, $userId);
}

$tasks_count = count($data_array['tasks']);
$tasks_ids = range(MIN_ID, $tasks_count);
shuffle($tasks_ids);
shuffle($users_ids);

foreach ($data_array['opinions'] as $opinion => $opinionValue) {
    $userId = rand(MIN_ID, $users_count - 1);
    $taskId = rand(MIN_ID, $tasks_count - 1);

    /**
     * Adding client_ids and task_ids into opinions
     */
    $data_array['opinions'][$opinion][] = $userId;
    $data_array['opinions'][$opinion][] = $taskId;
}

shuffle($users_ids);

foreach ($data_array['profiles'] as $profile => $profileValue) {
    $userId = rand(MIN_ID, $users_count - 1);
    $profileKeysCount = count($profileValue);

    while ($profileKeysCount < 5) {
        $data_array['profiles'][$profile][] = 'default';
        $profileKeysCount++;
    }
    /**
     * Adding contractor_ids into profiles
     */
    $data_array['profiles'][$profile][] = $userId;
}

shuffle($tasks_ids);
shuffle($users_ids);

foreach ($data_array['replies'] as $reply => $replyValue) {
    $userId = rand(MIN_ID, $users_count - 1);
    $taskId = rand(MIN_ID, $tasks_count - 1);

    $replyKeysCount = count($replyValue);

    while ($replyKeysCount < 3) {
        $data_array['replies'][$reply][] = 'default';
    }
    /**
     * Adding contractor_ids and task_ids into profiles
     */
    $data_array['replies'][$reply][] = $userId;
    $data_array['replies'][$reply][] = $taskId;
}

try {
    $connect = new DatabaseHelper('localhost','root',
        'testpassword2021', 'task_force');

    $connect->executeQuery($reply_drop_sql);
    $connect->executeQuery($profile_drop_sql);
    $connect->executeQuery($opinion_drop_sql);
    $connect->executeQuery($task_drop_sql);
    $connect->executeQuery($user_drop_sql);
    $connect->executeQuery($city_drop_sql);
    $connect->executeQuery($category_drop_sql);

    $connect->executeQuery($category_create_sql);
    $connect->executeQuery($city_create_sql);
    $connect->executeQuery($user_create_sql);
    $connect->executeQuery($task_create_sql);
    $connect->executeQuery($opinion_create_sql);
    $connect->executeQuery($profile_create_sql);
    $connect->executeQuery($reply_create_sql);

    foreach ($data_array['categories'] as $category) {
        $connect->executeQuery($category_insert_sql, $category);
    }

    foreach ($data_array['cities'] as $city) {
        $connect->executeQuery($city_insert_sql, $city);
    }

    foreach ($data_array['users'] as $user) {
        $connect->executeQuery($user_insert_sql, $user);
    }

    foreach ($data_array['tasks'] as $task) {
        $connect->executeQuery($task_insert_sql, $task);
    }

    foreach ($data_array['opinions'] as $opinion) {
        $connect->executeQuery($opinion_insert_sql, $opinion);
    }

    foreach ($data_array['profiles'] as $profile) {
        $connect->executeQuery($profile_insert_sql, $profile);
    }

    foreach ($data_array['replies'] as $reply) {
        $connect->executeQuery($reply_insert_sql, $reply);
    }

} catch (Exception $error) {
    error_log($error->getMessage());
}






