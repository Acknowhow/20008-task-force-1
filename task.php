<?php
use TaskForce\models\task\Task;
require_once __DIR__ . '/vendor/autoload.php';

const USER_ID = 123;

$task = new Task(
    Task::ACTIVE_STATE,
    Task::USER_ROLE, USER_ID);

assert($task->getCurrentlyAvailableActions() ==
    ['ACTION_APPLY']);

assert($task->getActiveState() ==
    Task::AVAILABLE_STATES[Task::ACTIVE_STATE], 'IS_NEW');

assert($task->getNextState('ACTION_APPLY') ==
    Task::AVAILABLE_ACTIONS[Task::USER_ROLE]['ACTION_APPLY'],
    'STATE_NEW');

assert($task->setNextState('STATE_PROGRESS') ==
    Task::AVAILABLE_STATES['STATE_PROGRESS'],
    'IN_PROGRESS');

assert($task->getActiveState() ==
    Task::AVAILABLE_STATES['STATE_PROGRESS'], 'IN_PROGRESS');



