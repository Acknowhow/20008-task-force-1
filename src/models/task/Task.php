<?php
namespace TaskForce\models\task;
use TaskForce\models\task\visitor\concrete\AbstractAction;

class Task
{
    const ACTIVE_STATE = 'STATE_NEW';
    const USER_ROLE = 'CONTRACTOR';

    const AVAILABLE_ACTIONS = [
        'CLIENT' => [
            'ACTION_ACCEPT' => 'STATE_PROGRESS',
            'ACTION_COMPLETE' => 'STATE_ACCOMPLISH',
            'ACTION_CANCEL' => 'STATE_CANCEL'
        ],
        'CONTRACTOR' => [
            'ACTION_APPLY' => 'STATE_NEW',
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

    const USER_ACTIONS = [
        'IS_NEW' => [
            'ACTION_ACCEPT', 'ACTION_CANCEL',
            'ACTION_COMPLETE', 'ACTION_APPLY'
        ],
        'IN_PROGRESS' => ['ACTION_ACCEPT', 'ACTION_DECLINE']
    ];

    private $contractorId = null;
    private $clientId = null;

    private $activeRole = '';
    private $activeState = '';

    /**
     * @var AbstractAction[] $actions
     */
    private $actions = [];

    public function __construct($activeState, $userRole,
                                $clientId, $contractorId = null)
    {
        $this->activeState = self::AVAILABLE_STATES[$activeState];
        $this->activeRole = $userRole;

        $this->clientId = $clientId;
        $this->contractorId = $contractorId;

    }

    public function addValidator(AbstractAction $action)
    {
        $this->actions[] = $action;
    }

    //** SetNextState with available action classes */
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

    // Gets userRole
    public function getAvailableActions()
    {
        return self::AVAILABLE_ACTIONS[$this->activeRole];
    }

    public function getCurrentlyAvailableActions()
    {
        if (!isset(self::USER_ACTIONS[$this->activeState])) {
            // ** Throw error ** //
            return 'Задача неактивна';

        } else {
            $availableActionsList = array_keys($this->getAvailableActions());
            $currentActions = self::USER_ACTIONS[$this->activeState];

            return array_values(array_intersect($availableActionsList,
                $currentActions));

            // ** Add ActionClass for each key in resulting array ** //
        }
    }

    public function getActiveState()
    {
        return $this->activeState;
    }
}
