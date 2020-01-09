<?php
use TaskForce\models\task\visitor\CompleteAction;
use TaskForce\models\task\visitor\AcceptAction;
use TaskForce\models\task\visitor\ApplyAction;
use TaskForce\models\task\visitor\CancelAction;
use TaskForce\models\task\visitor\DeclineAction;
use TaskForce\models\task\Task;

use TaskForce\exceptions\TaskArgumentException;
use TaskForce\exceptions\TaskActionException;

require_once __DIR__ . '/vendor/autoload.php';

const USER_IDS = [
    'USER_ID' => 123, 'CLIENT_ID' => null,
    'CONTRACTOR_ID' => 123
];
const ACTIVE_STATUS = 'STATUS_NEW';

try {
    $task = new Task(ACTIVE_STATUS, USER_IDS);
}
catch (TaskArgumentException $e) {
    print("Ошибка:" . $e->getMessage());
    die();
}

$task->addActionValidator(new CompleteAction(USER_IDS));
$task->addActionValidator(new AcceptAction(USER_IDS));
$task->addActionValidator(new ApplyAction(USER_IDS));
$task->addActionValidator(new CancelAction(USER_IDS));
$task->addActionValidator(new DeclineAction(USER_IDS));

try {
    $task->getAvailableActions();
    assert($task->getAvailableActions() ==
        ['ACTION_APPLY']);
}
catch (TaskActionException $e) {
    print("Ошибка:" . $e->getMessage());
    die();
}

assert($task->getActiveState() ==
    Task::AVAILABLE_STATUSES['STATUS_NEW'], 'IS_NEW');

assert($task->getNextState('ACTION_APPLY') ==
    Task::AVAILABLE_ACTIONS['ACTION_APPLY'],
    'STATUS_NEW');

assert($task->setNextStatus('STATUS_NEW') ==
    Task::AVAILABLE_STATUSES['STATUS_NEW'],
    'IS_NEW');


