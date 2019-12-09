<?php
namespace TaskForce\state;
use function TaskForce\helpers\key_compare;

class Task
{
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

    private const USER_ACTIONS = [
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

    public function getAvailableActions()
    {
        return self::AVAILABLE_ACTIONS[$this->activeRole];
    }

    public function getNextState($action)
    {
        $actions = $this->getAvailableActions();
        if (!isset($actions[$action])) {

            return 'Недопустимое действие';
        }

        $this->activeState = $actions[$action];

        return $actions[$action];
    }

    public function getCurrentlyAvailableActions()
    {
        if (!isset(self::USER_ACTIONS[$this->activeState])) {
            return 'Задача неактивна';

        } else {
            $currentActions = self::USER_ACTIONS[$this->activeState];
            $availableActions = $this->getAvailableActions();

            return key_compare(1, 2);

//            return array_intersect_ukey($availableActions, $currentActions, 'helpers\key_compare_func');
        }
    }

    public function getActiveState()
    {
        return $this->activeState;
    }
}
