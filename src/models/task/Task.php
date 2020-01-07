<?php
namespace TaskForce\models\task;
use TaskForce\models\task\visitor\concrete\AbstractAction;

class Task
{
    const AVAILABLE_ACTIONS = [
        'ACTION_ACCEPT' => 'STATE_PROGRESS',
        'ACTION_COMPLETE' => 'STATE_ACCOMPLISH',
        'ACTION_CANCEL' => 'STATE_CANCEL',
        'ACTION_APPLY' => 'STATE_NEW',
        'ACTION_DECLINE' => 'STATE_FAIL'
    ];

    const AVAILABLE_STATES = [
        'STATE_NEW' => 'IS_NEW',
        'STATE_PROGRESS' => 'IN_PROGRESS',
        'STATE_CANCEL' => 'IS_CANCELLED',
        'STATE_ACCOMPLISH' => 'IS_FINISHED',
        'STATE_FAIL' => 'IS_FAILED'
    ];

    const USER_ACTIONS = [
        'IS_NEW' => [
            'ACTION_APPLY', 'ACTION_ACCEPT', 'ACTION_CANCEL'
        ],
        'IN_PROGRESS' => [
            'ACTION_COMPLETE', 'ACTION_DECLINE'
        ]
    ];

    private $ids = [];
    private $activeState = '';

    /**
     * @var AbstractAction[] $actions
     */
    private $actionValidators = [];

    public function __construct($activeState, $ids = [
        'USER_ID' => null, 'CLIENT_ID' => null,
        'CONTRACTOR_ID' => null
    ])
    {
        $this->activeState = self::AVAILABLE_STATES[$activeState];
        $this->ids = $ids;
    }

    public function addActionValidator(AbstractAction $action)
    {
        $this->actionValidators[] = $action;
    }

    //** SetNextState with available action classes */
    public function setNextState($state)
    {
        $this->activeState = self::AVAILABLE_STATES[$state];
        return $this->activeState;
    }

    public function getNextState($action)
    {
        return self::AVAILABLE_ACTIONS[$action] ?? 'Недопустимое действие';
    }

    public function getAvailableActions()
    {
        $availableActions = self::USER_ACTIONS[$this->activeState] ?? null;

        if (!isset(self::USER_ACTIONS[$this->activeState])) {
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
        return $this->activeState;
    }
}
