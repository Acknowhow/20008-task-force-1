<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

use TaskForce\utils\FileLoader;
use TaskForce\exceptions\SourceFileException;
use TaskForce\exceptions\FileFormatException;

require_once __DIR__ . '/vendor/autoload.php';

/** Make loader iterator */

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
        error_log("Не удалось обработать csv файл: " . $error->getMessage());
    }
    catch (FileFormatException $error) {
        error_log("Неверная форма файла импорта: " . $error->getMessage());
    }

    $directory = substr($directory, 6, -4);
    $data_array[$directory] = $file;
}
$cities_count = count($data_array['cities']);
$cities_ids = range(MIN_ID, $cities_count);

shuffle($cities_ids);

foreach ($data_array['users'] as $user => $userValue) {

    $data_array['users'][$user][] =
        $cities_ids[rand(MIN_ID, $cities_count - 1)];
}

var_dump($data_array['users']);

/** Run iterator through each parameter in array */




