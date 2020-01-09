<?php
use TaskForce\models\task\visitor\CompleteAction;
use TaskForce\models\task\visitor\AcceptAction;
use TaskForce\models\task\visitor\ApplyAction;
use TaskForce\models\task\visitor\CancelAction;
use TaskForce\models\task\visitor\DeclineAction;

use TaskForce\models\task\Task;
require_once __DIR__ . '/vendor/autoload.php';

const USER_IDS = [
    'USER_ID' => 123, 'CLIENT_ID' => null,
    'CONTRACTOR_ID' => 123
];
const ACTIVE_STATE = 'STATE_NEW';
$task = new Task(ACTIVE_STATE, USER_IDS);

$task->addActionValidator(new CompleteAction(USER_IDS));
$task->addActionValidator(new AcceptAction(USER_IDS));
$task->addActionValidator(new ApplyAction(USER_IDS));
$task->addActionValidator(new CancelAction(USER_IDS));
$task->addActionValidator(new DeclineAction(USER_IDS));

assert($task->getAvailableActions() ==
    ['ACTION_APPLY']);

assert($task->getActiveState() ==
    Task::AVAILABLE_STATES['STATE_NEW'], 'IS_NEW');

assert($task->getNextState('ACTION_APPLY') ==
    Task::AVAILABLE_ACTIONS['ACTION_APPLY'],
    'STATE_NEW');

assert($task->setNextState('STATE_NEW') ==
    Task::AVAILABLE_STATES['STATE_NEW'],
    'IS_NEW');


