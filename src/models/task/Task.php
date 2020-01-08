<?php
namespace TaskForce\models\task;
use TaskForce\models\task\visitor\concrete\AbstractAction;

class Task
{
    const AVAILABLE_ACTIONS = [
        'ACTION_ACCEPT' => 'STATUS_PROGRESS',
        'ACTION_COMPLETE' => 'STATUS_ACCOMPLISH',
        'ACTION_CANCEL' => 'STATUS_CANCEL',
        'ACTION_APPLY' => 'STATUS_NEW',
        'ACTION_DECLINE' => 'STATUS_FAIL'
    ];

    const AVAILABLE_STATUSES = [
        'STATUS_NEW' => 'IS_NEW',
        'STATUS_PROGRESS' => 'IN_PROGRESS',
        'STATUS_CANCEL' => 'IS_CANCELLED',
        'STATUS_ACCOMPLISH' => 'IS_FINISHED',
        'STATUS_FAIL' => 'IS_FAILED'
    ];

    const USER_ACTIONS = [
        'IS_NEW' => [
            'ACTION_APPLY', 'ACTION_ACCEPT', 'ACTION_CANCEL'
        ],
        'IN_PROGRESS' => [
            'ACTION_COMPLETE', 'ACTION_DECLINE'
        ]
    ];

    private array $ids = [];
    private string $activeStatus = '';

    /**
     * @var AbstractAction[] $actions
     */
    private array $actionValidators = [];

    public function __construct(string $activeStatus, array $ids = [
        'USER_ID' => null, 'CLIENT_ID' => null,
        'CONTRACTOR_ID' => null
    ])
    {
        if (empty($activeStatus) || !is_string($activeStatus)) {

        }
        $this->activeStatus = self::AVAILABLE_STATUSES[$activeStatus];
        $this->ids = $ids;
    }

    public function addActionValidator(AbstractAction $action)
    {
        $this->actionValidators[] = $action;
    }

    //** SetNextState with available action classes */
    public function setNextState($state)
    {
        $this->activeStatus = self::AVAILABLE_STATUSES[$state];
        return $this->activeStatus;
    }

    public function getNextState($action)
    {
        return self::AVAILABLE_ACTIONS[$action] ?? 'Недопустимое действие';
    }

    public function getAvailableActions()
    {
        $availableActions = self::USER_ACTIONS[$this->activeStatus] ?? null;

        if (!isset(self::USER_ACTIONS[$this->activeStatus])) {
            // ** Throw error ** //
            return 'Задача неактивна';

        } else {
            $filteredArray = [];
            foreach ($availableActions as $availableAction) {
                foreach ($this->actionValidators as $actionValidator) {

                    if ($actionValidator->getUserActionName() ==
                        $availableAction) {

                        $filteredArray[] = $availableAction;
                    }

                }
            }
            return $filteredArray;
        }
    }

    public function getActiveState()
    {
        return $this->activeStatus;
    }
}
