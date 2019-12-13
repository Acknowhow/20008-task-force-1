<?php
namespace TaskForce\state;

class Task
{
    const ACTIVE_STATE = 'STATE_NEW';
    const USER_ROLE = 'CONTRACTOR';
    const USER_ID = 123;

    const AVAILABLE_ACTIONS = [
        'CLIENT' => [
            'ACTION_ACCEPT' => 'STATE_ACCOMPLISH',
            'ACTION_CANCEL' => 'STATE_CANCEL'
        ],
        'CONTRACTOR' => [
            'ACTION_APPLY' => 'STATE_PROGRESS',
            'ACTION_DECLINE' => 'STATE_FAIL'
        ]
    ];

    const AVAILABLE_STATES = [
        'STATE_NEW' => 'IS_NEW',
        'STATE_PROGRESS' => 'IN_PROGRESS',
        'STATE_CANCEL' => 'IS_CANCELLED',
        'STATE_ACCOMPLISH' => 'IS_FINISHED',
        'STATE_FAIL' => 'IS_FAILED'
    ];

    const USER_ROLES = [
        'USER_CLIENT' => 'CLIENT',
        'USER_CONTRACTOR' => 'CONTRACTOR'
    ];

    const USER_ACTIONS = [
        'IS_NEW' => ['ACTION_CANCEL', 'ACTION_APPLY'],
        'IN_PROGRESS' => ['ACTION_ACCEPT', 'ACTION_DECLINE']
    ];

    private $contractorId = null;
    private $clientId = null;
    private $completionDate = null;

    private $activeRole = '';
    private $activeState = '';


    public function __construct($activeState, $userRole, $userId)
    {
        $this->activeState = self::AVAILABLE_STATES[$activeState];
        $this->activeRole = $userRole;

        if ($userRole == self::USER_ROLES['USER_CONTRACTOR'])
        {
            $this->clientId = $userId;
        }

        else if ($userRole == self::USER_ROLES['USER_CLIENT'])
        {
            $this->contractorId = $userId;
        }
    }

    public function setNextState($state)
    {

        $this->activeState = self::AVAILABLE_STATES[$state];
        return $this->activeState;
    }

    public function getNextState($action)
    {
        $actions = $this->getAvailableActions();
        if (!isset($actions[$action])) {

            return 'Недопустимое действие';
        }

        return $actions[$action];
    }

    public function getAvailableActions()
    {
        return self::AVAILABLE_ACTIONS[$this->activeRole];
    }

    // Returns array keys intersection
    // by comparing associative and plain
    // array with additional key check
    public function getCurrentlyAvailableActions()
    {
        if (!isset(self::USER_ACTIONS[$this->activeState])) {
            return 'Задача неактивна';

        } else {
            $availableActionsList = array_keys($this->getAvailableActions());

            $currentActions = self::USER_ACTIONS[$this->activeState];

            return array_values(array_intersect($availableActionsList,
                $currentActions));
        }
    }

    public function getActiveState()
    {
        return $this->activeState;
    }
}
