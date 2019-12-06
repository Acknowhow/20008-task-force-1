<?php
use TaskForce\state\Task;
require_once __DIR__ . '/vendor/autoload.php';

$task = new Task(
    'STATE_NEW',
    'USER_CONTRACTOR', 123);

var_dump($task->getActiveState());
